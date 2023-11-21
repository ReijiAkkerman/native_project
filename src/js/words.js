class Words {
    #reverted;
    constructor() {
        this.#reverted = true;
        this.revert = this.revert.bind(this);
        this.shuffle = this.shuffle.bind(this);
    }

    revert() {
        let source = document.querySelector('.words_WordsSource');
        let translation = document.querySelector('.words_WordsTranslation');
        if(this.#reverted) {
            source.style.display = 'none';
            translation.style.display = 'block';
            this.#reverted = false;
        }
        else {
            translation.style.display = 'none';
            source.style.display = 'block';
            this.#reverted = true;
        }
    }

    shuffle() {
        
    }
}

var obj_words = new Words;

document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('.words_Words').addEventListener('click', obj_words.revert);
});