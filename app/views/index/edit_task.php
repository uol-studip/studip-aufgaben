<form action="<?= $controller->url_for($destination) ?>" method="post" class="default">
    <?= CSRFProtection::tokenTag() ?>
    <label>
        <span class="required">
            <?= $_('Titel') ?>
        </span>
        <input type="text" name="title" required value="<?= $task ? htmlReady($task['title']) : '' ?>">
    </label>

    <label>

        <span class="required"><?= $_('Aufgabenbeschreibung') ?></span>
        <textarea name="content" required><?= $task ? htmlReady($task['content']) : '' ?></textarea>
    </label>

    <label>
        <?= $_('Sichtbar und bearbeitbar ab') ?>:<br>
        <input type="text" data-datetime-picker name="startdate" placeholder="<?= $_('tt.mm.jjjj ss:mm') ?>" required
               value="<?= $task ? strftime('%d.%m.%Y %R', $task['startdate']) : '' ?>">
    </label>

    <label>
        <?= $_('Bearbeitbar bis') ?>:<br>
        <input type="text" data-datetime-picker name="enddate" placeholder="<?= $_('tt.mm.jjjj ss:mm') ?>" required
               value="<?= $task ? strftime('%d.%m.%Y %R', $task['enddate']) : '' ?>">
    </label>


    <label>
        <input type="checkbox" name="allow_text" value="1" <?= $task &&  $task['allow_text'] ? 'checked="checked"' : '' ?>>
        <?= $_('Texteingabe erlauben') ?>
    </label>

    <label>
        <input type="checkbox" name="allow_files" value="1" <?= $task && $task['allow_files'] ? 'checked="checked"' : '' ?>>
        <?= $_('Dateiupload erlauben') ?>
    </label>
    <footer data-dialog-button>
        <?= \Studip\Button::createAccept($_('Speichern')) ?>
        <?= \Studip\LinkButton::createCancel($_('Abbrechen'), $controller->url_for('index/view_task/' . $task['id'])) ?>
    </footer>
</form>
