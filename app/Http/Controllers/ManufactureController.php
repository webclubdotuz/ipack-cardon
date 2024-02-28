<?php

namespace App\Http\Controllers;

use App\Models\Manufacture;
use App\Services\TelegramService;
use Illuminate\Http\Request;

class ManufactureController extends Controller
{
    public function index()
    {
        return view('pages.manufactures.index');
    }

    public function create()
    {
        return view('pages.manufactures.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cardon_id' => 'required|exists:cardons,id',
            'quantity' => 'required|numeric',
        ]);

        $manufacture = Manufacture::create([
            'cardon_id' => $request->cardon_id,
            'user_id' => auth()->user()->id,
            'quantity' => $request->quantity,
            'description' => $request->description,
        ]);

        // 🔔🔔🔔🔔🔔🔔
        // 🛠Производство
        // 📦Товары: Щприц (Нукус Мед Тех)
        // 🖇Количество: 238 шт
        // 📅 Дата: 9 фев 2024 15:07
        // 👨‍💻 Менеджер: Марат

        $text = "🔔🔔🔔🔔🔔🔔\n🛠Производство\n📦Товары: {$manufacture->cardon->name}\n🖇Количество: {$manufacture->quantity} шт\n📅 Дата: {$manufacture->created_at->format('j M Y H:i')}\n👨‍💻 Менеджер: {$manufacture->user->fullname}";

        // Отправка уведомления в телеграм
        TelegramService::sendChannel($text);

        return redirect()->route('manufactures.create')->with('success', 'Успешно добавлено!');

    }
}
