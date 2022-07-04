class MonthlyCalendar 
{
	constructor(tasks, reservations, lines)
	{
		this.tasks = tasks;
		this.reservations = reservations;
		this.lines = lines;
		this.actualMonth = new Date().getMonth() + 1;
		this.actualYear = new Date().getFullYear();
	}

	load()
	{
		this.createCellId();
		this.printCalendarColors();
		this.printTasks();

		let months = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
		let month = document.getElementById('month');
		month.textContent = months[this.actualMonth - 1] + '  ' + this.actualYear;
	}

	createCellId()
	{
		let calendarLines = document.getElementsByTagName('tr');

		let dateId = [this.actualYear, this.actualMonth, '01'];
		if(dateId[1] < 10) dateId[1] = '0' + dateId[1];
		dateId[3] = dateId[0] + '-' + dateId[1] + '-' + dateId[2];

		for(let i = 1; i < calendarLines.length; i++)
		{
			calendarLines[i].id = dateId[3];
			dateId = this.incrementDate(dateId);
		}
	}

	emptyCells()
	{
		let dates = document.getElementsByTagName('td');

		for(let i = 0; i < dates.length; i++)
		{
			dates[i].style['background-color'] = 'transparent';
			dates[i].innerHTML = '';
		}
	}

	incrementDate(date)
	{
		let day = parseInt(date[2]);
		day++;

		if(day < 10) date[2] = '0' + day;
		else date[2] = day;

		date[3] = date[0] + '-' + date[1] + '-' + date[2];

		if(!isDateValid(date)) date[3] = 'none';

		return date;
	}

	printCalendarColors()
	{
		reservations = this.selectReservations(this.reservations);

		for(let i = 0; i < reservations.length; i++)
		{
			let actualDate = new Date(reservations[i].startDate);
			let endDate = new Date(reservations[i].endDate);

			while(actualDate <= endDate)
			{
				let actualTr = document.getElementById(dateToString(actualDate));

				if(actualTr != null)
				{
					let line = this.getLine(reservations[i].prodLineId);
					let actualTd = actualTr.querySelector('.' + line.name);

					actualTd.style['background-color'] = line.color;
				}

				actualDate.setDate(actualDate.getDate() + 1);
			}
		}
	}

	getLine(id)
	{
		for(let line of lines)
		{
			if(line.id == id) return line;
		}
	}

	printTasks()
	{
		let tasks = this.selectReservations(this.tasks);
		let resrvations = this.selectReservations(this.reservations);

		for(let i = 0; i < tasks.length; i++)
		{
			let actualDate = new Date(tasks[i].startDate);
			let endDate = new Date(tasks[i].endDate);

			while(actualDate <= endDate)
			{
				let actualTr = document.getElementsByClassName(dateToString(actualDate))[0];

				if(actualTr != null)
				{
					let actualTd = actualTr.querySelector('.' + this.selectLineNameFromTask(tasks[i]));
	
					if(dateToString(actualDate) == tasks[i].startDate)
						actualTd.innerHTML = '<a href=index.php?action=printTask&taskId='+tasks[i].id+'>'+tasks[i].name+'</a>';
					else
						actualTd.textContent = '-----';
				}

				actualDate.setDate(actualDate.getDate() + 1);
			}
		}
	}

	selectReservations(thingToClassify)
	{
		let reservationsList = [];

		for(let i = 0; i < thingToClassify.length; i++)
		{
			let startDate = new Date(thingToClassify[i].startDate);
			let endDate = new Date(thingToClassify[i].endDate);

			startDate = {'month' : startDate.getMonth() + 1, 'year' : startDate.getFullYear()};
			let actualDate = {'month' : this.actualMonth, 'year' : this.actualYear};
			endDate = {'month' : endDate.getMonth() + 1, 'year' : endDate.getFullYear()};

			if(this.isDateBetween(startDate, actualDate, endDate))
			{
				reservationsList.push(thingToClassify[i]);
			}
		}

		return reservationsList;
	}

	isDateBetween(date1, dateToVerify, date2)
	{
		if(this.isDateHigher(date1, dateToVerify)) return false;
		if(this.isDateHigher(dateToVerify, date2)) return false;
		return true;
	}

	isDateHigher(date1, date2)
	{
		if(date1['year'] > date2['year']) return true;
		if(date1['year'] < date2['year']) return false;

		if(date1['month'] > date2['month']) return true;
		if(date1['month'] < date2['month']) return false;
		
		return false;
	}


	getLineName(lineId)
	{
		for(let line of this.lines)
		{
			if(line.id === lineId)
			{
				return line.name;
			}
		}
	}

	selectLineNameFromTask(task)
	{
		for(let reservation of this.reservations)
		{
			if(task.reservationId == reservation.id)
			{
				return this.getLineName(reservation.prodLineId, this.lines);
			}
		}
	}

	changeMonth(moment)
	{
	this.emptyCells();

		if(moment == 'next') this.actualMonth++;
		if(moment == 'previous') this.actualMonth--;

		if(this.actualMonth < 1)
		{
			this.actualMonth = 12;
			this.actualYear--;
		}
		else if(this.actualMonth > 12)
		{
			this.actualMonth = 1;
			this.actualYear++;
		}

		this.load();
	}
}


function isDateValid(date)
{
	if(isNaN(Date.parse(date[3]))) return false;
	return true;
}
