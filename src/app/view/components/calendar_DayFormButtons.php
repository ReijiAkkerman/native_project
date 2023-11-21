<?php
    use project\view\components\DayFormButtons;
    
    require_once __DIR__ . '/core/calendar/DayFormButtons.php';
?>

<div class="calendar_DayFormButtons">
    <div class="main_buttons">
        <div>
            <button class="__cancel" onclick="calendar.showNewEntry();">
                <svg viewBox="0 0 32 32">
                    <path d="M28,29a1,1,0,0,1-.71-.29l-24-24A1,1,0,0,1,4.71,3.29l24,24a1,1,0,0,1,0,1.42A1,1,0,0,1,28,29Z"/>
                    <path d="M4,29a1,1,0,0,1-.71-.29,1,1,0,0,1,0-1.42l24-24a1,1,0,1,1,1.42,1.42l-24,24A1,1,0,0,1,4,29Z"/>
                </svg>
            </button>
        </div>
        <div>
        <?php (new DayFormButtons)->paste() ?>
        </div>
    </div>
</div>