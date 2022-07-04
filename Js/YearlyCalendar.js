class YearlyCalendar 
{
	constructor(tasks, reservations, lines)
	{
		this.tasks = tasks;
		this.reservations = reservations;
		this.lines = lines;

		this.actualYear = new Date().getFullYear();
	}

	load()
	{
		this.createCellId();
		this.createDivs();
		this.printCalendarColors();
		this.printTasks();

		let year = document.getElementById("year");
		year.textContent = this.actualYear;
	}

	changeYear(moment)
	{
		this.emptyCells();

		if(moment == 'next') this.actualYear++;
		if(moment == 'previous') this.actualYear--;

		this.load();
	}

	printCalendarColors()
	{
		let reservations = this.selectReservationsByYear(this.reservations);

		for(let i = 0; i < reservations.length; i++)
		{
			var actualDate = new Date(reservations[i].startDate);
			var endDate = new Date(reservations[i].endDate);

			while(actualDate <= endDate)
			{
				let actualTd = document.getElementById(dateToString(actualDate));

				if(actualTd != null)
				{
					let actualDiv = actualTd.querySelector('div');
					actualDiv = actualDiv.querySelector(`.a${reservations[i].id}`);

					let line = this.getLine(reservations[i].prodLineId);
	
					actualDiv.style['background-color'] = line.color;
				}
				
				actualDate.setDate(actualDate.getDate() + 1);
			}
		}
	}

	printTasks()
	{
		let tasks = this.selectReservationsByYear(this.tasks);

		for(let i = 0; i < tasks.length; i++)
		{
			let actualDate = new Date(tasks[i].startDate);
			let endDate = new Date(tasks[i].endDate);

			while(actualDate <= endDate)
			{
				let actualTd = document.getElementById(dateToString(actualDate));
				let actualDiv = actualTd.querySelector('div');
				actualDiv = actualDiv.querySelector(`.a${tasks[i].reservationId}`);

				if(dateToString(actualDate) == tasks[i].startDate)
				{
					actualDiv.innerHTML = '<a href=index.php?action=printTask&taskId='+tasks[i].id+'>'+tasks[i].name+'</a>';
				}
				else
				{
					actualDiv.textContent += '-----';
				}

				actualDate.setDate(actualDate.getDate() + 1);
			}
		}
	}

	selectReservationsByYear(thingToClassify)
	{
		let tasksList = [];

		for(let i = 0; i < thingToClassify.length; i++)
		{
			let reservDate = new Date(thingToClassify[i].startDate);
			let endReservDate = new Date(thingToClassify[i].endDate);

			if(this.actualYear >= reservDate.getFullYear() && this.actualYear <= endReservDate.getFullYear())
			{
				tasksList.push(thingToClassify[i]);
			}
		}

		return tasksList;
	}

	createCellId()
	{
		let dates = document.getElementsByTagName('td');

		let dateId = [this.actualYear, '01', '01', this.actualYear+'-01-01'];
		
		for(let i = 0; i < dates.length; i++)
		{
			dates[i].id = dateId[3];
			dateId = incrementDate(dateId);
		}
	}

	emptyCells()
	{
		let dates = document.getElementsByClassName('dayContainer');

		for(let i = 0; i < dates.length; i++)
		{
			dates[i].style['background-color'] = 'transparent';
			dates[i].innerHTML = '';
		}
	}

	createDivs()
	{
		for(let i = 1; i <= 12; i++)
		{
			let monthTd = this.getMonthDiv(i);
			let monthReservations = this.getReservationsOfMonth(i);

			for(let j = 0; j < monthTd.length; j++)
			{
				let width = 100 / monthReservations.length;
				let height = 22;

				for(let k = 0; k < monthReservations.length; k++)
				{
					let newDiv = document.createElement('div');
					newDiv.className = 'a' + monthReservations[k].id;

					newDiv.style['width'] = `${width}%`;
					newDiv.style['height'] = `${height}px`;

					monthTd[j].appendChild(newDiv);
				}
			}
		}
	}

	getReservationsOfMonth(month)
	{
		month = parseInt(month);
		let yearReservations = this.selectReservationsByYear(this.reservations);
		let monthReservations = [];

		for(let i = 0; i < yearReservations.length; i++)
		{
			let startDate = new Date(yearReservations[i].startDate);
			let endDate = new Date(yearReservations[i].endDate);

			startDate = {'month' : startDate.getMonth() + 1, 'year' : startDate.getFullYear()};
			endDate = {'month' : endDate.getMonth() + 1, 'year' : endDate.getFullYear()};
			let actualDate = {'month' : month, 'year' : this.actualYear};

			if(this.isDateBetween(startDate, actualDate, endDate))
			{
				monthReservations.push(yearReservations[i]);
			}
		}

		return monthReservations;
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

	getMonthDiv(month)
	{
		let tds = document.getElementsByTagName('td');
		let monthDivs = [];

		for(let td of tds)
		{
			let tdDate = new Date(td.id);

			if(tdDate.getMonth() + 1 == month)
			{
				monthDivs.push(td.querySelector('div'));
			}
		}

		return monthDivs;
	}

	getLine(lineId)
	{
		for(let line of this.lines)
		{
			if(line.id == lineId) return line;
		}
	}
}

/************************************************************************************/

function incrementDate(date)
{
	let month = parseInt(date[1]);
	let day = parseInt(date[2]);

	// Incrementation of the month
	month++;

	if(month > 12) 
	{
		month = 1;
		day++;
	}

	if(month < 10) date[1] = '0' + month;
	else date[1] = month;

	if(day < 10) date[2] = '0' + day;
	else date[2] = day;
	
	date[3] = date[0]+'-'+date[1]+'-'+date[2];
	if(!isDateValid(date)) date[3] = 'none';

	return date;
}

/************************************************************************************/

function isDateValid(date)
{
	if(isNaN(Date.parse(date[3]))) return false;
	return true;
}

/************************************************************************************/

function dateToString(date)
{
	let year = date.getFullYear();
	let month = date.getMonth() + 1;
	let day = date.getDate();

	if(month < 10) month = '0' + month;
	if(day < 10) day = '0' + day;

	return year + '-' + month + '-' + day;
}

/************************************************************************************/