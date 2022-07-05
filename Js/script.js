function displayReservations(reservations, prodLines)
{
	var reservDiv = document.getElementById('reservations');

	for(let i = 0; i < reservations.length; i++)
	{
		newLink = document.createElement('a');
		newLink.href = "index.php?action=addTask&step=form&reservationId=" + reservations[i].id;

		newLink.setAttribute('id', reservations[i].id);
		newLink.setAttribute('class', 'reservation');

		newLink.style['background-color'] = prodLines[i].color;

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