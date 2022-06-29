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

/************************************************************************************/
