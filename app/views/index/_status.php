<table class="default zebra">
    <thead>
        <tr>
            <th><?= $_('TeilnehmerIn') ?></th>
            <th colspan="2" style="width: 10%; text-align: center"><?= $_('in Arbeit') ?></th>
            <th style="width: 10%"><?= $_('letzte Aktivit�t') ?></th>
            <th colspan="2" style="width: 10%; text-align: center"><?= $_('Feedback') ?></th>
            <th><?= $_('Hinweis') ?></th>
            <th style="width: 2%"><?= $_('Fertig?') ?></th>
            <th class="actions"><?= $_('Aktionen') ?></th>
        </tr>
    </thead>
    <tbody>
        <? foreach ($participants as $user) : ?>
            <? if ($user->status != 'dozent') : ?>
                <? $task_user = $task->task_users->findOneBy('user_id', $user->user_id) ?>
                <? if (!$task_user) :  // create missing entries on the fly
                    $task_user = EPP\TaskUsers::create([
                        'user_id'     => $user->user_id,
                        'chdate'      => 0,
                        'mkdate'      => 0,
                        'ep_tasks_id' => $task->getId()
                    ]);
                endif ?>
                <tr>
                    <td>
                        <a href="<?= $controller->url_for("index/view_dozent/" . $task_user->id) ?>">
                            <?= get_fullname($user->user_id) ?>
                        </a>
                    </td>

                    <td style="text-align: right">
                        <?= (!$task_user || $task_user->answer === null) ? '0' : strlen($task_user->answer) ?>
                        <?= Icon::create('file-text', 'info', tooltip2($_('Antworttext'))) ?>
                    </td>
                    <td>
                        <?= $task_user ? sizeof($task_user->files->findBy('type', 'answer')) : 0 ?>
                        <?= Icon::create('file-generic', 'info', tooltip2($_('Hochgeladene Dateien'))) ?>
                    </td>
                    <td>
                        <?= ($task_user && $task_user->chdate) ? strftime($timeformat, $task_user->chdate) : '-' ?>
                    </td>

                    <td style="text-align: right">
                        <?= (!$task_user || $task_user->feedback === null) ? '0' : strlen($task_user->feedback) ?>
                        <?= Icon::create('file-text', 'info', tooltip2($_('Antworttext'))) ?>
                    </td>
                    <td>
                        <?= $task_user ? sizeof($task_user->files->findBy('type', 'feedback')) : 0 ?>
                        <?= Icon::create('file-generic', 'info', tooltip2($_('Hochgeladene Dateien'))) ?>
                    </td>
                    <td>
                        <?= ($task_user && $task_user->hint)
                            ? Assets::img('icons/16/black/file-text.png', [
                                'title' => $_('F�r diese Aufgabe wurden Hinweise f�r sie hinterlegt!')
                            ]) : '-' ?>
                    </td>
                    <td>
                        <? if ($task_user->ready) : ?>
                            <?= Icon::create('accept', 'accept')?>
                        <? else : ?>
                            <?= Icon::create('decline', 'attention')?>
                        <? endif ?>
                    </td>
                    <td class="actions">
                        <a href="<?= $controller->url_for("index/view_dozent/" . $task_user->id) ?>">
                            <?= Icon::create('edit', 'clickable', tooltip2($_('Diese Aufgabe f�r diesen Nutzer bearbeiten'))) ?>
                        </a>
                    </td>
                </tr>
            <? endif ?>
        <? endforeach ?>
    </tbody>
</table>
