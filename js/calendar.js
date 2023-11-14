class Calendar {
    #shown;

    constructor() {
        this.#shown = false;
        this.showNewEntry = this.showNewEntry.bind(this);
        this.showExistentEntry = this.showExistentEntry.bind(this);
        this.saveEntry = this.saveEntry.bind(this);
        this.pasteEntry = this.pasteEntry.bind(this);
    }

    showNewEntry() {
        this.#displayEntry();
        this.#showButtons_new();
    }

    showExistentEntry(event) {
        this.#displayEntry();
        this.#showButtons_existent();
        event.stopPropagation();
    }

    showTitle() {
        let array = {
            '__save': 'Сохранить',
            '__cancel': 'Закрыть'
        };
        if(!common.shown) common.showActions();
        let element = document.querySelector('.common_showTitle');
        let className = this.className.split(' ');
        element.textContent = array[className[0]];
    }

    hideTitle() {
        let element = document.querySelector('.common_showTitle');
        element.textContent = '';
    }

    completeFields_newEntry() {
        let classnames = this.className.split(' ');
        let date = classnames[1].split('_');
        let datetime = new Date();
        document.querySelector('[name="title"]').value = '';
        document.querySelector('[name="description"]').value = '';
        document.querySelector('[name="start_year"]').value = date[1];
        document.querySelector('[name="start_month"]').value = date[2];
        document.querySelector('[name="start_day"]').value = date[3];
        document.querySelector('[name="end_year"]').value = date[1];
        document.querySelector('[name="end_month"]').value = date[2];
        document.querySelector('[name="end_day"]').value = date[3];
        document.querySelector('[name="start_hour"]').value = datetime.getHours();
        document.querySelector('[name="start_minute"]').value = datetime.getMinutes();
        if((datetime.getHours() + 1) < 23) {
            document.querySelector('[name="end_hour"]').value = datetime.getHours() + 1;
            document.querySelector('[name="end_minute"]').value = datetime.getMinutes();
        }
        else {
            document.querySelector('[name="end_hour"]').value = datetime.getHours();
            document.querySelector('[name="end_minute"]').value = 59;
        }
    }

    completeFields_existentEntry() {
        let xhr = new XMLHttpRequest();
        xhr.open('GET', `../action/calendar/getEntry?ID=${this.id}`);
        xhr.send();
        xhr.responseType = 'json';
        xhr.onload = () => {
            let element = document.querySelector('.calendar_DayFormInfo');
            element.querySelector('[name="title"]').value = xhr.response['title'];
            element.querySelector('[name="description"]').value = xhr.response['description'];
            let time = new Date(xhr.response['start_action'] * 1000);
            element.querySelector('[name="start_day"]').value = time.getDate();
            element.querySelector('[name="start_month"]').value = time.getMonth();
            element.querySelector('[name="start_year"]').value = time.getFullYear();
            element.querySelector('[name="start_hour"]').value = time.getHours();
            element.querySelector('[name="start_minute"]').value = time.getMinutes();
            time.setTime(xhr.response['end_action'] * 1000);
            element.querySelector('[name="end_day"]').value = time.getDate();
            element.querySelector('[name="end_month"]').value = time.getMonth();
            element.querySelector('[name="end_year"]').value = time.getFullYear();
            element.querySelector('[name="end_hour"]').value = time.getHours();
            element.querySelector('[name="end_minute"]').value = time.getMinutes();
        };
    }

    saveEntry() {
        let data_element = document.querySelector('.calendar_Day form');
        let data = new FormData(data_element);
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '../action/calendar/createEntry');
        xhr.send(data);
        xhr.responseType = 'json';
        xhr.onload = () => {
            this.pasteEntry(xhr.response);
            this.#displayEntry();
        };

        let element = document.querySelectorAll('.calendar_CalendarBodyDayBody button');
        element.addEventListener('click', calendar.showExistentEntry);
        element.addEventListener('click', calendar.completeFields_existentEntry);
    }

    pasteEntry(data) {
        let template = document.querySelector('template.calendar_CalendarBodyDayBody');
        let element = template.content.cloneNode(true);
        element.querySelector('button').id = this.#getCurrentId(data['id']);
        element.querySelector('pre').append(data['title']);
        let insertionPlace = document.querySelector(`.${data['className']} .calendar_CalendarBodyDayBody`);
        insertionPlace.append(element);
    }

    #displayEntry() {
        let element = document.querySelector('.calendar_Day');
        if(this.#shown) {
            element.style.display = 'none';
            this.#shown = false;
        }
        else {
            element.style.display = 'flex';
            this.#shown = true;
        }
    }

    #showButtons_new() {
        let new_elements = document.querySelectorAll('.calendar_DayFormButtons .new');
        let existent_elements = document.querySelectorAll('.calendar_DayFormButtons .existent');
        for(let element of existent_elements) {
            element.style.display = 'none';
        }
        for(let element of new_elements) {
            element.style.display = 'block';
        }
    }

    #showButtons_existent() {
        let new_elements = document.querySelectorAll('.calendar_DayFormButtons .new');
        let existent_elements = document.querySelectorAll('.calendar_DayFormButtons .existent');
        for(let element of new_elements) {
            element.style.display = 'none';
        }
        for(let element of existent_elements) {
            element.style.display = 'block';
        }
    }

    #getCurrentId(id) {
        let id_number = id.split('_')[1];
        id_number++;
        return 'entry_' + id_number;
    }
}

var calendar = new Calendar;

document.addEventListener('DOMContentLoaded', function() {
    for(let element of document.querySelectorAll('.calendar_CalendarBodyDay')) {
        element.addEventListener('click', calendar.showNewEntry);
        element.addEventListener('click', calendar.completeFields_newEntry);
    }
    for(let element of document.querySelectorAll('.calendar_DayFormButtons button')) {
        element.addEventListener('mouseover', calendar.showTitle);
        element.addEventListener('mouseout', calendar.hideTitle);
    }
    for(let element of document.querySelectorAll('.calendar_CalendarBodyDayBody button')) {
        element.addEventListener('click', calendar.showExistentEntry);
        element.addEventListener('click', calendar.completeFields_existentEntry);
    }
})