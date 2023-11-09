<?php
    include_once __DIR__ . '/core/Calendar.php';
?>

<!DOCTYPE html>
<html>
<?php include_once __DIR__ . '/components/head.php' ?>
    <body>
    <?php include_once __DIR__ . '/components/header.php' ?>
    <?php include_once __DIR__ . '/components/common_Navigation.php' ?>
        <main>
            <section class="calendar_Calendar">
                <div class="calendar_CalendarHeader">
                    <div>ВС</div>
                    <div>ПН</div>
                    <div>ВТ</div>
                    <div>СР</div>
                    <div>ЧТ</div>
                    <div>ПТ</div>
                    <div>СБ</div>
                </div>
                <div class="calendar_CalendarBody">
                <?php (new project\view\Calendar)->createCalendar() ?>
                </div>
            </section>
            <section class="calendar_Day">
                <div class="calendar_DayForm">
                    <div class="calendar_DayFormInfo">
                        <form action="#">
                            <div class="title">
                                <p>Название</p>
                                <input type="text" name="title">
                            </div>
                            <div class="description">
                                <p>Описание</p>
                                <textarea name="description"></textarea>
                            </div>
                            <div class="timestamp">
                                <p>Время выполнения</p>
                                <div>
                                    <div class="start">
                                        <p>Начало</p>
                                        <div>
                                            <div class="date">
                                                <div>
                                                    <p>День</p>
                                                    <input type="text" name="start_day" maxlength="2">
                                                </div>
                                                <div>
                                                    <p>Месяц</p>
                                                    <input type="text" name="start_month" maxlength="2">
                                                </div>
                                                <div>
                                                    <p>Год</p>
                                                    <input type="text" name="start_year" maxlength="4">
                                                </div>
                                            </div>
                                            <div class="time">
                                                <div>
                                                    <p>Час</p>
                                                    <input type="text" name="start_hour" maxlength="2">
                                                </div>
                                                <div>
                                                    <p>Минута</p>
                                                    <input type="text" name="start_minute" maxlength="2">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="end">
                                        <p>Конец</p>
                                        <div>
                                            <div class="date">
                                                <div>
                                                    <p>День</p>
                                                    <input type="text" name="end_day" maxlength="2">
                                                </div>
                                                <div>
                                                    <p>Месяц</p>
                                                    <input type="text" name="end_month" maxlength="2">
                                                </div>
                                                <div>
                                                    <p>Год</p>
                                                    <input type="text" name="end_year" maxlength="4">
                                                </div>
                                            </div>
                                            <div class="time">
                                                <div>
                                                    <p>Час</p>
                                                    <input type="text" name="end_hour" maxlength="2">
                                                </div>
                                                <div>
                                                    <p>Минута</p>
                                                    <input type="text" name="end_minute" maxlength="2">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php include __DIR__ . '/components/calendar_DayFormButtons.php' ?>
                </div>
            </section>
        </main>
        <footer>

        </footer>
        <script src="../../js/common.js"></script>
        <script src="../../js/calendar.js"></script>
    </body>
</html>