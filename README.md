# AutorizationSystem

Добрый день!


Вход в программу осуществляется через файл public/index.php.
В нем мы загружаем конфиги и автозагрузчик. Далее инициализируем класс DB (класс для работы с БД). И собственно стартуем наше приложение(App::start()).
Используемая архитектура mvc.

И так, загружаем в роутер возможные регулярные выражения, по которым будем определять существующие пути и сообственно запускаем сам Router.
Из url получаем нужный нам Controller и Action, которые в последствии мы инициализируем и вызовим соответственно.
