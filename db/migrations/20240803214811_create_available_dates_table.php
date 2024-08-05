<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

final class CreateAvailableDatesTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('available_dates', ['id' => false, 'primary_key' => 'id']);
        $table->addColumn('id', 'char', [
            'limit' => 36,
            'null' => false
        ])
            ->addColumn('date', 'date', ['null' => false])
            ->addColumn('time', 'json', ['null' => true])
            ->addColumn('created_at', 'datetime', ['default' => Literal::from('CURRENT_TIMESTAMP')])
            ->addColumn('updated_at', 'datetime', [
                'null' => true,
                'default' => Literal::from('CURRENT_TIMESTAMP'),
                'update' => 'CURRENT_TIMESTAMP'
            ])
            ->create();

        // Add the trigger to set UUID on insert
        $this->execute('
            CREATE TRIGGER before_insert_available_dates
            BEFORE INSERT ON available_dates
            FOR EACH ROW
            SET NEW.id = UUID();
        ');
    }
}
