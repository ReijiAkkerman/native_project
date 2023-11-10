class Calendar {
    #shown;

    constructor() {
        this.#shown = false;
        this.showNewEntry = this.showNewEntry.bind(this);
    }

    showNewEntry() {
        this.#displayNewEntry();
        this.#showButtons_new();
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

    supplyFields() {
        let classnames = this.className.split(' ');
        let date = classnames[1].split('_');
        let datetime = new Date();
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

    async saveEntry() {
        let data_element = document.querySelector('.calendar_Day form');
        let data = new FormData(data_element);
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '../action/calendar/createEntry');
        xhr.send(data);
        xhr.responseType = 'text';
        xhr.onload = () => {
            alert(xhr.response);
        }
    }

    #displayNewEntry() {
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
        element.addEventListener('click', calendar.supplyFields);
    }
    for(let element of document.querySelectorAll('.calendar_DayFormButtons button')) {
        element.addEventListener('mouseover', calendar.showTitle);
        element.addEventListener('mouseout', calendar.hideTitle);
    }
})