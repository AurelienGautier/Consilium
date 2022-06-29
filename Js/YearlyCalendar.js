class YearlyCalendar 
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
		this.printTasks();
		this.printCalendarColors();

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

	printTasks()
	{
		let tasks = this.selectReservationsByYear(this.tasks);

		for(let i = 0; i < tasks.length; i++)
		{
			let actualDate = new Date(tasks[i].startDate);
			let endDate = new Date(tasks[i].endDate);

			while(actualDate <= endDate)
			{
				let newTd = document.getElementById(dateToString(actualDate));

				if(dateToString(actualDate) == tasks[i].startDate)
				{
					newTd.innerHTML = '<a href=index.php?action=printTask&taskId='+tasks[i].id+'>'+tasks[i].name+'</a>';
				}
				else
				{
					newTd.textContent += '-----';
				}

				actualDate.setDate(actualDate.getDate() + 1);
			}
		}
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

				actualTd.style['background-color'] = reservations[i].color;

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

			if(reservDate.getFullYear() == this.actualYear)
			{
				tasksList.push(thingToClassify[i]);
			}
		}

		return tasksList;
	}

	getLineName(lineId)
	{
		for(line of this.lines)
		{
			if(line.id === lineId)
			{
				return line.name;
			}
		}
	}

	selectLineNameFromTask(task)
	{
		for(reservation of this.reservations)
		{
			if(task.reservationId == reservation.id)
			{
				return getLineName(reservation.prodLineId, this.lines);
			}
		}
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
		let dates = document.getElementsByTagName('td');

		for(let i = 0; i < dates.length; i++)
		{
			dates[i].style['background-color'] = 'transparent';
			dates[i].innerHTML = '';
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