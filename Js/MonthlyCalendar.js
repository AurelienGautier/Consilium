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
			calendarLines[i].className = dateId[3];
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
				let actualTr = document.getElementsByClassName(dateToString(actualDate))[0];

				if(actualTr != null)
				{
					let actualTd = actualTr.querySelector('.' + this.getLineName(reservations[i].prodLineId));
					actualTd.style['background-color'] = reservations[i].color;
				}

				actualDate.setDate(actualDate.getDate() + 1);
			}
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
			let reservDate = new Date(thingToClassify[i].startDate);
			let endReservDate = new Date(thingToClassify[i].endDate);

			if((this.actualMonth >= reservDate.getMonth() + 1 && this.actualMonth <= endReservDate.getMonth() + 1) &&
				reservDate.getFullYear() == this.actualYear)
			{
				reservationsList.push(thingToClassify[i]);
			}
		}

		return reservationsList;
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
