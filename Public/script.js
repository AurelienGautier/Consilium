class Calendar 
{
	constructor(tasks, reservations, lines)
	{
		this.tasks = tasks;
		this.reservations = reservations;
		this.lines = lines;
		this.actualMonth = new Date().getMonth() + 1;
		this.actualYear = new Date().getFullYear();
	}

	printTasks()
	{
		for(let i = 0; i < this.tasks.length; i++)
		{
			let actualDate = new Date(this.tasks[i].startDate);
			let endDate = new Date(this.tasks[i].endDate);

			while(actualDate <= endDate)
			{
				let newTd = document.getElementById(dateToString(actualDate));

				if(dateToString(actualDate) == this.tasks[i].startDate)
				{
					newTd.innerHTML = '<a href=index.php?action=printTask&taskId='+this.tasks[i].id+'>'+this.tasks[i].name+'</a>';
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
		for(let i = 0; i < this.reservations.length; i++)
		{
			var actualDate = new Date(this.reservations[i].startDate);
			var endDate = new Date(this.reservations[i].endDate);

			while(actualDate <= endDate)
			{
				let actualTd = document.getElementById(dateToString(actualDate));

				actualTd.style['background-color'] = this.reservations[i].color;

				actualDate.setDate(actualDate.getDate() + 1);
			}
		}
	}

	printMonthlyTasks()
	{
		tasks = selectReservations(this.tasks, this.actualMonth);
		resrvations = selectReservations(this.reservations, this.actualMonth);

		for(let i = 0; i < this.tasks.length; i++)
		{
			let actualDate = new Date(this.tasks[i].startDate);
			let endDate = new Date(this.tasks[i].endDate);

			while(actualDate <= endDate)
			{
				let actualTr = document.getElementById(dateToString(actualDate));

				let actualTd = actualTr.querySelector('.' + selectLineNameFromTask(tasks[i]));

				if(dateToString(actualDate) == tasks[i].startDate)
				{
					actualTd.innerHTML = '<a href=index.php?action=printTask&taskId='+tasks[i].id+'>'+tasks[i].name+'</a>';
				}
				else
				{
					actualTd.textContent = '-----';
				}

				actualDate.setDate(actualDate.getDate() + 1);
			}
		}
	}

	printMonthlyCalendarColors()
	{
		reservations = selectReservations();

		for(let i = 0; i < this.reservations.length; i++)
		{
			let actualDate = new Date(reservations[i].startDate);
			let endDate = new Date(reservations[i].endDate);

			while(actualDate <= endDate)
			{
				let actualTr = document.getElementById(dateToString(actualDate));

				let actualTd = actualTr.querySelector('.' + getLineName(reservations[i].prodLineId));
				actualTd.style['background-color'] = reservations[i].color;

				actualDate.setDate(actualDate.getDate() + 1);
			}
		}
	}

	selectReservations()
	{
		let reservationsList = [];

		for(let i = 0; i < this.reservations.length; i++)
		{
			let reservDate = new Date(reservations[i].startDate);

			if(reservDate.getMonth() + 1 == this.actualMonth)
			{
				reservationsList.push(this.reservations[i]);
			}
		}

		return reservationsList;
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

		let dateId = ['2022', '01', '01', '2022-01-01'];
		
		for(let i = 0; i < dates.length; i++)
		{
			dates[i].id = dateId[3];
			dateId = incrementDate(dateId);
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

function displayReservations(reservations, prodLines)
{
	var reservDiv = document.getElementById('reservations');

	for(let i = 0; i < reservations.length; i++)
	{
		newLink = document.createElement('a');
		newLink.href = "index.php?action=addTask&step=form&reservationId=" + reservations[i].id;

		newLink.setAttribute('id', reservations[i].id);
		newLink.setAttribute('class', 'reservation');

		newLink.style['background-color'] = reservations[i].color;

		newLink.appendChild(addReservationInfos('Ligne', prodLines[i].name));
		newLink.appendChild(addReservationInfos('du', reservations[i].startDate));
		newLink.appendChild(addReservationInfos('au', reservations[i].endDate));

		reservDiv.appendChild(newLink);
	}
}

/************************************************************************************/

function addReservationInfos(info, data)
{
	newParagraph = document.createElement('p');
	newParagraph.setAttribute('class', 'reservInfos');
	newParagraph.textContent = info + ' ' + data;

	return newParagraph;
}
