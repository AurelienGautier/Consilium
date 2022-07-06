function displayReservations(reservations, prodLines, url)
{
	var reservDiv = document.getElementById('reservations');

	for(let i = 0; i < reservations.length; i++)
	{
		newLink = document.createElement('a');
		newLink.href = 'index.php?action=' + url + reservations[i].id;

		newLink.setAttribute('id', reservations[i].id);
		newLink.setAttribute('class', 'reservation');

		newLink.style['background-color'] = prodLines[i].color;
		newLink.style['color'] = 'aliceblue';

		newLink.appendChild(addReservationInfos('Ligne', prodLines[i].name));
		newLink.appendChild(addReservationInfos('du', reservations[i].startDate));
		newLink.appendChild(addReservationInfos('au', reservations[i].endDate));

		reservDiv.appendChild(newLink);
	}
}

/************************************************************************************/

function displayTasks(tasks, taskTypes, suppliers, url)
{
	var taskDiv = document.getElementById('tasks');

	for(let i = 0; i < tasks.length; i++)
	{
		newLink = document.createElement('a');
		newLink.href = 'index.php?action=' + url + tasks[i].id;

		newLink.setAttribute('id', tasks[i].id);
		newLink.setAttribute('class', 'task');

		newLink.style['color'] = 'black';
		
		newLink.appendChild(addReservationInfos('Nom', tasks[i].name));
		newLink.appendChild(addReservationInfos('Type de tâche', taskTypes[i].name));
		newLink.appendChild(addReservationInfos('du', tasks[i].startDate));
		newLink.appendChild(addReservationInfos('au', tasks[i].endDate));

		if(suppliers[i] != null)
			newLink.appendChild(addReservationInfos('Fournisseur', suppliers[i].name));
		else 
			newLink.appendChild(addReservationInfos('Fournisseur', 'Aucun'));


		taskDiv.appendChild(newLink);
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

/************************************************************************************/

// à factoriser
function isDateValid(date)
{
	if(isNaN(Date.parse(date[3]))) return false;
	return true;
}

/************************************************************************************/

// à factoriser
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