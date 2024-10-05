<?php
include '../getAPI/getAPI.php';

if (isset($_POST['city'])) {
    $defaultCity = $_POST['city'];
} else {
    $defaultCity = 'Seiyun';
}
$cities = [
    'Seiyun' => 'سيئون',
    'Aden' => 'عدن',
    'Ibb' => 'إب',
    'Sanaa' => 'صنعاء',
    'Taizz' => 'تعز',
    'Almukalla' => 'المكلا',
    'Mareb' => 'مارب',
    'Sadah' => 'صعدة',
    'Albayda' => 'البيضاء',
    'Dhamar' => 'ذمار',
    'tarim' => 'تريم',
    'AlGhaydah' => 'الغيظة',
    'WadiAin' => 'وادي العين',
];
$prayerTimes = [
    'Fajr' => 'الفجر',
    'Sunrise' => 'الشروق',
    'Dhuhr' => 'الظهر',
    'Asr' => 'العصر',
    'Maghrib' => 'المغرب',
    'Isha' => 'العشاء',
];
// رابط API لجلب مواقيت الآذان بناءً على المدينة المختارة
$praies = GetApi::fetchData("http://api.aladhan.com/v1/timingsByCity?country=ye&city=$defaultCity");
?>

<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مواقيت الآذان</title>
    <link rel="icon" type="image/png" href="img/adhan.png">
    <link href="css/bootstrap.css" rel="stylesheet">
    <style>
        body {
            background-color: #1e0033;
            color: white;
            font-family: Arial, sans-serif;
            text-align: center;
        }

        select {
            margin-left: 560px;
            margin-top: 10px;
            direction: rtl;
        }

        .card-header {
            background-color: #1578d0;
            color: white;
            font-family: Arial, sans-serif;
            text-align: center;
            font-weight: bold;
            font-size: 20px;
        }

        .card-body {
            font-family: Arial, sans-serif;
            text-align: center;
            font-weight: bold;
            font-size: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col text-center mt-3">
                <h1 id="cityName">
                    <?php echo $cities[$defaultCity]; ?>
                </h1>
                <h2 id="date">
                    <?php echo $praies['data']['date']['readable'] ?> - <?php echo $praies['data']['date']['hijri']['weekday']['ar'] ?>
                </h2>
            </div>
        </div>
        <hr>
        <div class="row text-center mt-3">
            <?php foreach ($prayerTimes as $prayerkey => $prayer) { ?>
                <div class="col-2">
                    <div class="card">
                        <div class="card-header"><?php echo $prayer ?></div>
                        <div class="card-body" id="<?php echo $prayerkey ?>">
                            <?php echo date("g:i A", strtotime($praies['data']['timings'][$prayerkey])) ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="row">
            <div class="col text-center mt-3">
                <h1 id="cityTitle">اختر مدينة</h1>
                <form method="POST" action="">
                    <select name="city" class="form-select" style="width: 150px; " onchange="this.form.submit()">
                        <?php
                        foreach ($cities as $cityKey => $cityName) {
                            echo '<option value="' . $cityKey . '" ' . ($defaultCity == $cityKey ? 'selected' : '') . '>' . $cityName . '</option>';
                        }
                        ?>
                    </select>
                </form>
            </div>
        </div>
    </div>

</body>

</html>