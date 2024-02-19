<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->char('phone', 9);
            $table->enum('type', ['customer', 'supplier', 'both']);
            $table->string('address')->nullable();

            $table->unique(['phone', 'type']);

            $table->timestamps();
        });

        $contacts = array(
            array('id' => '1','fullname' => 'По умолчанию','phone' => '123456789','type' => 'both','address' => 'По умолчанию','created_at' => '2024-01-29 23:10:57','updated_at' => NULL),
            array('id' => '2','fullname' => 'Арыслан (Клеше)','phone' => '971777670','type' => 'supplier','address' => 'Ташкент','created_at' => '2024-01-30 00:05:00','updated_at' => '2024-02-19 13:59:47'),
            array('id' => '3','fullname' => 'Оберточный Цех','phone' => '912588008','type' => 'both','address' => 'Гербиш Завод','created_at' => '2024-01-30 00:07:50','updated_at' => '2024-02-19 13:46:52'),
            array('id' => '4','fullname' => 'Руслан (Шимбай) Май','phone' => '912473393','type' => 'customer','address' => 'Шимбай','created_at' => '2024-02-07 19:03:24','updated_at' => '2024-02-19 13:47:54'),
            array('id' => '5','fullname' => 'Полат (Хожели) Май','phone' => '991692700','type' => 'customer','address' => 'Хожели','created_at' => '2024-02-19 13:49:44','updated_at' => '2024-02-19 13:49:44'),
            array('id' => '6','fullname' => 'Коныс (Нукус Мед Тех)','phone' => '913948808','type' => 'customer','address' => 'Ул, Беруний Нукус Мед Тех','created_at' => '2024-02-19 13:51:29','updated_at' => '2024-02-19 13:51:29'),
            array('id' => '7','fullname' => 'Яшнар Лаззат (Торт)','phone' => '913074808','type' => 'customer','address' => 'Ул. Татибаев','created_at' => '2024-02-19 13:56:21','updated_at' => '2024-02-19 13:56:21'),
            array('id' => '8','fullname' => 'Музаффар (ЗОР ЗОР)','phone' => '905750445','type' => 'customer','address' => '60 жыллык','created_at' => '2024-02-19 13:57:28','updated_at' => '2024-02-19 13:58:50'),
            array('id' => '9','fullname' => 'Бехруз (Тортомастер)','phone' => '934883635','type' => 'customer','address' => 'Нокис Базар','created_at' => '2024-02-19 13:58:35','updated_at' => '2024-02-19 13:58:35'),
            array('id' => '10','fullname' => 'Мийрас (УЗ КОР ГАЗ)','phone' => '937707771','type' => 'customer','address' => 'Конырат Ак Шолак','created_at' => '2024-02-19 14:00:50','updated_at' => '2024-02-19 14:00:50'),
            array('id' => '11','fullname' => 'Камила (Краска)','phone' => '900443744','type' => 'supplier','address' => 'Ташкент','created_at' => '2024-02-19 14:01:37','updated_at' => '2024-02-19 14:01:37'),
            array('id' => '12','fullname' => 'Хурсандбек (Matbaa Paper)','phone' => '995601560','type' => 'supplier','address' => 'Хорезм Ургенш','created_at' => '2024-02-19 14:03:24','updated_at' => '2024-02-19 14:03:24'),
            array('id' => '13','fullname' => 'Шахноза (Клеше)','phone' => '998818116','type' => 'supplier','address' => 'Ташкент','created_at' => '2024-02-19 14:04:24','updated_at' => '2024-02-19 14:04:24'),
            array('id' => '14','fullname' => 'Ажинияз (Теплица)','phone' => '973530805','type' => 'customer','address' => 'Т-таш','created_at' => '2024-02-19 14:05:22','updated_at' => '2024-02-19 14:05:22'),
            array('id' => '15','fullname' => 'Ислам (VIVIAN LEGEND)','phone' => '913055515','type' => 'customer','address' => 'Нокис','created_at' => '2024-02-19 14:06:33','updated_at' => '2024-02-19 14:06:33'),
            array('id' => '16','fullname' => 'Кутлугбек (Крахмал)','phone' => '909860088','type' => 'supplier','address' => 'Ташкент','created_at' => '2024-02-19 14:08:36','updated_at' => '2024-02-19 14:08:36'),
            array('id' => '17','fullname' => 'Жавлон (Тигел Пышак)','phone' => '998442020','type' => 'supplier','address' => 'Ташкент','created_at' => '2024-02-19 14:10:27','updated_at' => '2024-02-19 14:10:27'),
            array('id' => '18','fullname' => 'Кушмаг ','phone' => '979923003','type' => 'customer','address' => 'Саранша','created_at' => '2024-02-19 14:11:06','updated_at' => '2024-02-19 14:11:06'),
            array('id' => '19','fullname' => 'Бабур (Степлер сим) Ак','phone' => '935857771','type' => 'supplier','address' => 'Ташкент','created_at' => '2024-02-19 14:12:08','updated_at' => '2024-02-19 14:12:08'),
            array('id' => '20','fullname' => 'VAQF FONDI Ислам Ага','phone' => '974745168','type' => 'customer','address' => 'Нокис','created_at' => '2024-02-19 14:14:34','updated_at' => '2024-02-19 14:14:44'),
            array('id' => '21','fullname' => 'Сухроб (Степлер Сим) Сары','phone' => '915229377','type' => 'supplier','address' => 'Самарканд','created_at' => '2024-02-19 14:15:38','updated_at' => '2024-02-19 14:15:38'),
            array('id' => '22','fullname' => 'Памир (Артел)','phone' => '906639400','type' => 'customer','address' => 'Нокис','created_at' => '2024-02-19 14:23:02','updated_at' => '2024-02-19 14:23:02'),
            array('id' => '23','fullname' => 'Илхом (Имзо)','phone' => '977043230','type' => 'customer','address' => 'Нокис','created_at' => '2024-02-19 14:23:27','updated_at' => '2024-02-19 14:23:27'),
            array('id' => '24','fullname' => 'Амударя Техтил','phone' => '941492109','type' => 'customer','address' => 'Амударя ','created_at' => '2024-02-19 14:24:08','updated_at' => '2024-02-19 14:24:08')
          );


        DB::table('contacts')->insert($contacts);


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
