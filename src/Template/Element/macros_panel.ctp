<table>
    <thead>
    <tr>
        <th><?= h(__d('macro', 'Identifer')); ?></th>
        <th><?= h(__d('macro', 'Parameters')); ?></th>
        <th><?= h(__d('macro', 'Context')); ?></th>
        <th><?= h(__d('macro', 'Options')); ?></th>
        <th><?= h(__d('macro', 'Result')); ?></th>
        <th><?= h(__d('macro', 'Took (ms)')); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($runs as $run): ?>
        <tr>
            <td><?= h($run['identifier']); ?></td>
            <td><?= $this->Toolbar->makeNeatArray($run['parameters']); ?></td>
            <td>
                <?php
                switch (gettype($run['context'])):
                    case 'boolean':
                    case 'integer':
                    case 'double':
                    case 'string':
                        echo h($run['context']);

                        break;
                    case 'object':
                    case 'array':
                        echo h(get_class($run['context']));
                        break;
                    case 'NULL':
                        echo h(__d('macro', 'None'));
                endswitch;
                ?>
            </td>
            <td><?= $this->Toolbar->makeNeatArray($run['options']); ?></td>
            <td><?= h($run['result']); ?></td>
            <td><?= h($this->Number->format($run['elapsedTime'])); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
