<?php 
    use project\view\components\Header;

    require_once __DIR__ . '/core/common/Header.php';
?>
<header class="common_header">
    <div class="common_Header">
        <div class="common_HeaderActions">
            <button onclick="common.showActions();"><h1>&#x3e_</h1></button>
            <div class="common_showActions up">
                <form action="#" method="POST">
                    <input type="text" placeholder="Искомое значение...">
                    <button>
                        <svg viewBox="0 0 24 24">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.0392 15.6244C18.2714 14.084 19.0082 12.1301 19.0082 10.0041C19.0082 5.03127 14.9769 1 10.0041 1C5.03127 1 1 5.03127 1 10.0041C1 14.9769 5.03127 19.0082 10.0041 19.0082C12.1301 19.0082 14.084 18.2714 15.6244 17.0392L21.2921 22.707C21.6828 23.0977 22.3163 23.0977 22.707 22.707C23.0977 22.3163 23.0977 21.6828 22.707 21.2921L17.0392 15.6244ZM10.0041 17.0173C6.1308 17.0173 2.99087 13.8774 2.99087 10.0041C2.99087 6.1308 6.1308 2.99087 10.0041 2.99087C13.8774 2.99087 17.0173 6.1308 17.0173 10.0041C17.0173 13.8774 13.8774 17.0173 10.0041 17.0173Z"/>
                        </svg>
                    </button>
                </form>
                <?php (new Header)->paste() ?>
            </div>
            <p class="common_showTitle"></p>
        </div>
        <h1>Native Project.</h1>
    </div>
</header>