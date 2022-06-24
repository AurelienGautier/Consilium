function changeType(field)
{
    var taskName = document.getElementById(field);
    taskName.innerHTML = '<input class="changing" placeholder="Entrer le nouveau nom" />';
}

/************************************************************************************/

function printTasks(tasks)
{
    console.log(tasks);
    for(let i = 0; i < tasks.length; i++)
    {
        var actualDate = new Date(tasks[i].startDate);
        var endDate = new Date(tasks[i].endDate);

        while(actualDate <= endDate)
        {
            let newTd = document.getElementById(dateToString(actualDate));

            if(dateToString(actualDate) == tasks[i].startDate)
            {
                newTd.textContent = tasks[i].name;
            }
            else
            {
                newTd.textContent = '-----';
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
//         var supplierList = document.createElement("select");
//         supplierList.id ="supplierList";

//         for(let i = 0; i < suppliers.length; i++)
//         {
//             supplierList[i] = new Option(suppliers[i]['nom_fournisseur'], suppliers['id_fournisseur']);
//         }

//         form.insertBefore(supplierList, supplierNeeded.nextSibling);
//         form.insertBefore(labelSupplierList, supplierNeeded.nextSibling);

// function addSupplier(suppliers)
// {
//     var taskType = document.getElementById("stopType");
//     taskType.onchange = function() {
//         if(taskType.value == 2)
//         {
//             var form = document.getElementById("formAddTask");

//             var supplierList = document.createElement("select");
//             supplierList.id = "supplierList";

//             for(let i = 0; i < suppliers.length; i++)
//             {
//                 supplierList[i] = new Option(suppliers[i]['nom_fournisseur'], suppliers['id_fournisseur']);
//             }

//             form.insertBefore();
//         }
//         else
//         {

//         }
//     }
// }

/************************************************************************************/
