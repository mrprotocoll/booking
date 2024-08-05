<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

final class CreateAppointmentsTable extends AbstractMigration
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
        $table = $this->table('appointments', ['id' => false, 'primary_key' => 'id']);
        $table->addColumn('id', 'char', [
            'limit' => 36,
            'null' => false
        ])
            ->addColumn('name', 'string', ['limit' => 255])
            ->addColumn('email', 'string', ['limit' => 255])
            ->addColumn('telephone', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('comment', 'text')
            ->addColumn('date', 'date')
            ->addColumn('time', 'char', [
                'limit' => 10,
                'null' => false
            ])
            ->addColumn('status', 'string', ['default' => 'active'])
            ->addColumn('created_at', 'datetime', ['default' => Literal::from('CURRENT_TIMESTAMP')])
            ->addColumn('updated_at', 'datetime', [
                'null' => true,
                'default' => Literal::from('CURRENT_TIMESTAMP'),
                'update' => 'CURRENT_TIMESTAMP'
            ])
            ->create();

        // Add the trigger to set UUID on insert
        $this->execute('
            CREATE TRIGGER before_insert_appointments
            BEFORE INSERT ON appointments
            FOR EACH ROW
            SET NEW.id = UUID();
        ');
    }
}
