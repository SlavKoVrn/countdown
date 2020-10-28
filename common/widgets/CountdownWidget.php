<?php
namespace common\widgets;

use common\models\StockExchange;

use Yii;
use yii\base\Widget;
use yii\helpers\Url;

class CountdownWidget extends Widget
{

	public $id = '';

    private $name = '';
    private $city = '';
    private $on;
    private $off;
    private $red;

	public function init()
	{
		parent::init();

        $this->name = StockExchange::STOCK_EXCHANGE[$this->id]['name'];
        $this->city = StockExchange::STOCK_EXCHANGE[$this->id]['city'];
	}

	public function run()
	{

		parent::run();

		$this->registryScript();

		return $this->render('countdown', [
			'id' => $this->id,
            'name' => $this->name,
            'city' => $this->city,
            'on' => $this->on,
            'off' => $this->off,
            'red' => $this->red,
		]);
	}

	protected function registryScript()
	{
        $path = Yii::$app->getAssetManager()->publish(__DIR__ . '/assets/img/');
        $this->on = $path[1].'/on.png';
        $this->off = $path[1].'/off.png';
        $this->red = $path[1].'/red.png';

		$this->getView()->registerJsFile('https://cdn.jsdelivr.net/npm/vue/dist/vue.js');

        $urlCountdown = Url::to('/countdown/get-rest');
		$script = <<<JS
		    var getRest_$this->id = function ()
            {
                $.ajax({
                   url: '$urlCountdown',
                   data:{id:'$this->id'},
                   dataType:'json'
                }).done(function (data) {
                    console.log(data);
                    window.type_$this->id = data.type;
                    window.miliseconds_$this->id = data.miliseconds;
                    var Moscow = document.getElementById('$this->id-Moscow');
                    var moscowSpan = Moscow.querySelector('.Moscow');
                    moscowSpan.innerHTML = data.moscow;
                    initCountDown_$this->id();
                });
            };

            function getTimeRemaining_$this->id(endtime) {
              var t = Date.parse(endtime) - Date.parse(new Date());
              var seconds = Math.floor((t / 1000) % 60);
              var minutes = Math.floor((t / 1000 / 60) % 60);
              var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
              var days = Math.floor(t / (1000 * 60 * 60 * 24));
              return {
                'total': t,
                'days': days,
                'hours': hours,
                'minutes': minutes,
                'seconds': seconds
              };
            }
             
            function initializeClock_$this->id(id, endtime) {
              var clock = document.getElementById(id);
              var daysSpan = clock.querySelector('.days');
              var hoursSpan = clock.querySelector('.hours');
              var minutesSpan = clock.querySelector('.minutes');
              var secondsSpan = clock.querySelector('.seconds');
              var stateSpan = clock.querySelector('.state');
             
              function updateClock_$this->id() {
                var t = getTimeRemaining_$this->id(endtime);
             
                daysSpan.innerHTML = t.days + ':';
                if (t.days == 0){
                    daysSpan.style.display='none';
                }
                hoursSpan.innerHTML = ('0' + t.hours).slice(-2) + ':';
                minutesSpan.innerHTML = ('0' + t.minutes).slice(-2) + ':';
                secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);
             
                  var on = document.getElementById('$this->id-on');
                  var off = document.getElementById('$this->id-off');
                  var red = document.getElementById('$this->id-red');
                  if (window.type_$this->id == 'open'){
                      stateSpan.innerHTML = ' закроются ';
                      if (on.style.display == 'none'){
                          on.style.display = 'block';
                          off.style.display = 'none';
                          red.style.display = 'none';
                      }else{
                          on.style.display = 'none';
                          off.style.display = 'block';
                          red.style.display = 'none';
                      }
                  }else{
                      stateSpan.innerHTML = ' откроются ';
                      on.style.display = 'none';
                      off.style.display = 'none';
                      red.style.display = 'block';
                  }
                
                window.current_$this->id += 1;
                if ((window.current_$this->id >= (2 * 60)) && (t.seconds == 0)){
                    clearInterval(timeinterval_$this->id);
                    getRest_$this->id();
                }
                if (t.total <= 0) {
                    clearInterval(timeinterval_$this->id);
                    getRest_$this->id();
                }
              }
             
              updateClock_$this->id();
              var timeinterval_$this->id = setInterval(updateClock_$this->id, 1000);
            }
            
            function initCountDown_$this->id(){
                window.current_$this->id = 0;
                var deadline = new Date(Date.parse(new Date()) + parseInt(window.miliseconds_$this->id));
                initializeClock_$this->id('$this->id-countdown', deadline);
            }

            getRest_$this->id();
JS;

        $css = <<<CSS

            .Moscow {
              font-family: sans-serif;
              font-size: 20px;
            }
             
            .stock {
              font-family: sans-serif;
              font-size: 20px;
            }
             
            .days {
              font-family: sans-serif;
              font-size: 20px;
            }
             
            .hours {
              font-family: sans-serif;
              font-size: 20px;
            }
             
            .minutes {
              font-family: sans-serif;
              font-size: 20px;
            }
             
            .seconds {
              font-family: sans-serif;
              font-size: 20px;
            }
             
CSS;

        $this->getView()->registerJs($script, \yii\web\View::POS_END);
        $this->getView()->registerCss($css);

	}

}