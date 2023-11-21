class Common {
    shown;

    constructor() {
        this.shown = false;
        this.showActions = this.showActions.bind(this);
    }

    showActions() {
        let element = document.querySelector('.common_showActions');
        if(this.shown) {
            element.style.display = 'none';
            this.shown = false;
        }
        else {
            element.style.display = 'flex';
            this.shown = true;
        }
    }

    showTitle() {
        let array = {
            '__synchronize': 'Синхронизировать данные',
            '__logout': 'Выйти',
            '__shuffle': 'Перемешать слова',
            '__upload': 'Загрузить новые слова'
        };
        let element = document.querySelector('.common_showTitle');
        element.textContent = array[this.className];
    }

    hideTitle() {
        let element = document.querySelector('.common_showTitle');
        element.textContent = '';
    }
}

var common = new Common;

document.addEventListener('DOMContentLoaded', function() {
    for(let element of document.querySelectorAll('.common_HeaderActions > div > button')) {
        element.addEventListener('mouseover', common.showTitle);
        element.addEventListener('mouseout', common.hideTitle);
    }
})