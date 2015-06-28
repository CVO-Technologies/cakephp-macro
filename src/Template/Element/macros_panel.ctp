<table>
    <thead>
    <tr>
        <td><?= h(__d('macro', 'Identifer')); ?></td>
        <td><?= h(__d('macro', 'Result')); ?></td>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($runs as $run): ?>
        <tr>
            <td><?= h($run['identifier']); ?></td>
            <td><?= h($run['result']); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
