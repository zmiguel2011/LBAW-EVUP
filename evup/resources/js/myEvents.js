const getOrganizingEvents = () => {
    sendAjaxRequest('get', `api/myEvents/organizing`, null, getOrganizingEventsHandler);
}

function getOrganizingEventsHandler() {
    const events = JSON.parse(this.responseText)
    const area = document.getElementById("myeventsarea")
    area.innerHTML = events

    /* Rerun flowbite's modal code the event listeners are added again*/
    initModal(selectors)
}

const getMyEvents = (hasPassed) => {
    sendAjaxRequest('post', `api/myEvents/onMyAgenda`, { 'hasPassed': hasPassed }, getMyEventsHandler);
}

function getMyEventsHandler() {
    const events = JSON.parse(this.responseText)
    const area = document.getElementById("myeventsarea")
    area.innerHTML = events

    /* Rerun flowbite's modal code the event listeners are added again*/
    initModal(selectors)
}
