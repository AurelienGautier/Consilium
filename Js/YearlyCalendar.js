class YearlyCalendar 
{
	constructor(tasks, reservations)
	{
		this.tasks = tasks;
		this.reservations = reservations;
		this.actualMonth = new Date().getMonth() + 1;
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
	
					actualDiv.style['background-color'] = reservations[i].color;
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

	getReservationsOfMonth(month)
	{
		month = parseInt(month);
		let reservations = this.selectReservationsByYear(this.reservations);
		let monthReservations = [];

		for(let i = 0; i < reservations.length; i++)
		{
			let startDate = new Date(reservations[i].startDate);
			let endDate = new Date(reservations[i].endDate);

			if((endDate.getFullYear() == this.actualYear && month >= startDate.getMonth() + 1 && month <= endDate.getMonth() + 1) ||
			   (endDate.getFullYear() > this.actualYear && month >= startDate.getMonth() + 1) ||
			   (startDate.getFullYear() < this.actualYear && month <= endDate.getMonth() + 1))
			{
				monthReservations.push(reservations[i]); 
			}
		}

		return monthReservations;
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

	getMonthDiv(month)
	{
		let tds = document.getElementsByTagName('td');
		let monthTds = [];

		for(let td of tds)
		{
			let tdDate = new Date(td.id);

			if(tdDate.getMonth() + 1 == month)
			{
				monthTds.push(td.querySelector('div'));
			}
		}

		return monthTds;
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