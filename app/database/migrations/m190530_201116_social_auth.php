<?php

use yii\db\Migration;

class m190530_201116_social_auth extends Migration
{
    public function up(): void
    {
        $this->createTable(
            "auth_client",
            [
                'id' => $this->primaryKey(),

                // auth_user id
                'user_id' => $this->integer()->notNull(),

                // social client data
                'source' => $this->string()->notNull(),
                'source_id' => $this->string()->notNull(),
            ]
        );

        $this->addForeignKey(
            'fk-auth-user_id-user-id',
            'auth_client',
            'user_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function down(): void
    {
        $this->dropForeignKey('fk-auth-user_id-user-id', 'auth_client');
        $this->dropTable('auth_client');
    }
}
