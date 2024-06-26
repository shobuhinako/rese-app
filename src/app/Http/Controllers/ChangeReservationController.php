<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Http\Requests\ChangeReservationRequest;

class ChangeReservationController extends Controller
{
    public function edit($id, $shop_name)
    {
        $startHour = 10;
        $endHour = 21;

        // 時間の選択肢の配列の初期化
        $timeOptions = [];

        for ($hour = $startHour; $hour <= $endHour; $hour++) {
        // 各時間の30分前を追加します
        $timeOptions[] = sprintf('%02d:00:00', $hour); // 例: '10:00', '11:00', ...
        if ($hour < $endHour) {
        $timeOptions[] = sprintf('%02d:30:00', $hour); // 例: '10:30', '11:30', ...
        }
        }

        // 人数の選択肢の配列の初期化
        $numberOfPeopleOptions = [];
        for ($i = 1; $i <= 10; $i++) {
        $numberOfPeopleOptions[] = $i . '人';
        }

        $reservationContent = Reservation::find($id);

        // // 予約された時間が選択肢の中にあるかどうかをチェックして、あればそれを選択されたものにする
        $selectedTime = \Carbon\Carbon::parse($reservationContent->reservation_time);

        $timeOptions[] = $selectedTime->format('H:i');

        return view ('/reservation_change', compact('shop_name', 'reservationContent', 'timeOptions', 'numberOfPeopleOptions', 'selectedTime'));
    }

    public function update(ChangeReservationRequest $request, $id)
    {
        $form = $request->all();
        unset($form['_token']);
        Reservation::find($id)->update($form);
        return redirect('/mypage');
    }
}
