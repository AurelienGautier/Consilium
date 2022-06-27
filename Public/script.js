function printTasks(tasks)
{
    for(let i = 0; i < tasks.length; i++)
    {
        var actualDate = new Date(tasks[i].startDate);
        var endDate = new Date(tasks[i].endDate);

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

/************************************************************************************/

function printCalendarColors(reservations)
{
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

/************************************************************************************/

function printMonthlyTasks(reservations, tasks, lines, month)
{
    tasks = selectReservations(tasks, month);
    resrvations = selectReservations(reservations, month);

    for(let i = 0; i < tasks.length; i++)
    {
        var actualDate = new Date(tasks[i].startDate);
        var endDate = new Date(tasks[i].endDate);

        while(actualDate <= endDate)
        {
            let actualTr = document.getElementById(dateToString(actualDate));

            let actualTd = actualTr.querySelector('.' + selectLineNameFromTask(tasks[i], reservations, lines));

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

/************************************************************************************/

function printMonthlyCalendarColors(reservations, lines, month)
{
    reservations = selectReservations(reservations, month);

    for(let i = 0; i < reservations.length; i++)
    {
        var actualDate = new Date(reservations[i].startDate);
        var endDate = new Date(reservations[i].endDate);

        while(actualDate <= endDate)
        {
            let actualTr = document.getElementById(dateToString(actualDate));

            let actualTd = actualTr.querySelector('.' + getLineName(reservations[i].prodLineId, lines));
            actualTd.style['background-color'] = reservations[i].color;

            actualDate.setDate(actualDate.getDate() + 1);
        }
    }
}

/************************************************************************************/

function selectReservations(reservations, month)
{
    let reservationsList = [];

    for(let i = 0; i < reservations.length; i++)
    {
        let reservDate = new Date(reservations[i].startDate);

        if(reservDate.getMonth() + 1 == month)
        {
            reservationsList.push(reservations[i]);
        }
    }

    return reservationsList;
}

/************************************************************************************/

function getLineName(lineId, lines)
{
    for(line of lines)
    {
        if(line.id === lineId)
        {
            return line.name;
        }
    }
}

/************************************************************************************/

function selectLineNameFromTask(task, reservations, lines)
{
    for(reservation of reservations)
    {
        if(task.reservationId == reservation.id)
        {
            return getLineName(reservation.prodLineId, lines);
        }
    }
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
