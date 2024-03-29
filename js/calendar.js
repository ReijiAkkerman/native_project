class Calendar {
    id;

    #shown;
    #format;

    constructor() {
        this.#shown = false;
        this.showNewEntry = this.showNewEntry.bind(this);
        this.showExistentEntry = this.showExistentEntry.bind(this);
        this.saveEntry = this.saveEntry.bind(this);
        this.deleteEntry = this.deleteEntry.bind(this);
        this.pasteEntry = this.pasteEntry.bind(this);
    }

    showNewEntry() {
        this.#displayEntry();
        this.#showButtons_new();
        this.#format = 'createEntry';
    }

    showExistentEntry(event) {
        this.#displayEntry();
        this.#showButtons_existent();
        this.#format = 'changeEntry';
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
            element.querySelector('[name="start_month"]').value = time.getMonth() + 1;
            element.querySelector('[name="start_year"]').value = time.getFullYear();
            element.querySelector('[name="start_hour"]').value = time.getHours();
            element.querySelector('[name="start_minute"]').value = time.getMinutes();
            time.setTime(xhr.response['end_action'] * 1000);
            element.querySelector('[name="end_day"]').value = time.getDate();
            element.querySelector('[name="end_month"]').value = time.getMonth() + 1;
            element.querySelector('[name="end_year"]').value = time.getFullYear();
            element.querySelector('[name="end_hour"]').value = time.getHours();
            element.querySelector('[name="end_minute"]').value = time.getMinutes();
        };
    }

    saveEntry() {
        let data_element = document.querySelector('.calendar_Day form');
        let data = new FormData(data_element);
        let xhr = new XMLHttpRequest();
        xhr.open('POST', `../action/calendar/${this.#format}/${this.id}`);
        xhr.send(data);
        xhr.responseType = 'json';
        xhr.onload = () => {
            // alert(xhr.response);
            switch(this.#format) {
                case 'createEntry':
                    this.pasteEntry(xhr.response);
                    this.#displayEntry();
                    break;
                case 'changeEntry':
                    this.editEntry(xhr.response);
                    this.#displayEntry();
                    break;
            };
        };
    }

    deleteEntry() {
        let xhr = new XMLHttpRequest();
        xhr.open('DELETE', `../action/calendar/deleteEntry/${this.id}`);
        xhr.send();
        xhr.responseType = 'json';
        xhr.onload = () => {
            let element = document.querySelector(`#entry_${this.id}`);
            element.remove();
            this.#displayEntry();
        };
    }

    pasteEntry(data) {
        let template = document.querySelector('template.calendar_CalendarBodyDayBody');
        let element = template.content.cloneNode(true);
        element.querySelector('button').id = data['id'];
        element.querySelector('pre').append(data['title']);
        let insertionPlace = document.querySelector(`.${data['className']} .calendar_CalendarBodyDayBody`);
        insertionPlace.append(element);

        let button = document.querySelector(`#${data['id']}`);
        button.addEventListener('click', this.showExistentEntry);
        button.addEventListener('click', this.completeFields_existentEntry);
        button.addEventListener('click', this.setId);
    }

    editEntry(data) {
        let button = document.querySelector(`#${data['id']}`);
        let element = button.querySelector('pre');
        element.textContent = '';
        element.textContent = data['title'];
    }

    setId() {
        let id = this.id.split('_')[1];
        calendar.id = id;
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
        element.addEventListener('click', calendar.setId);
    }
})