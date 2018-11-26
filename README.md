# Exchange rate 

#ТЗ

Есть большая система, которая приносит значительный доход компании и следовательно к качеству её кода предъявляются высокие требования.
 
 Эта система, помимо всего прочего, использует курсы валют.
 
 Логика получения курсов валют следующая. Клиентская сторона может получить их из кеша, из базы данных и из внешнего источника по http. В случае, если курса валют нет в кеше, надо проверить базу, и если там есть, положить в кеш. Если в базе нет -- проверить внешний источник и положить и в базу, и в кеш.
 
 Надо реализовать эту логику. Предполагается, что она будет использоваться в куче разных мест.
 
 Вероятно, в условии есть неточности, какое-то поведение не указано и тд. Нужно самостоятельно принять решение что делать в каждом таком случае и явно это пометить -- либо в комментарии, либо в файле типа readme. В этом же файле напишите, что бы вы сделали по-другому, будь у вас больше времени; какие у вас были соображения, как в целом должен выглядеть этот код, к чему вы вообще стремились.

# How to run 

- install docker (https://www.docker.com/get-started)
- copy repository 
``git clone git@github.com:VyalovAlexander/ExchangeRateRepository.git``
- move to folder with repository
- run ``docker-compose up -d --build``
- when containers will be ready, run
``docker ps``
- find CONTAINER_ID with "_php" on the end nad run
``run docker exec -it CONTAINER_ID bash``
- ``run php index.php``

# Environment variables (.env || .env.example)

- DB_DRIVER=pgsql #PDO driver
- DB_HOST=postgres #DB host (not localhost because we use docker)
- DB_PORT=5432 #Standart Postgres port
- DB_NAME=db #Just name of db
- DB_USER=homestead #Just db username
- DB_PASSWORD=secret #Just db password
- DB_EXTERNAL_PORT=5500 #Port to connect postgres oustside the container

- REDIS_HOST=redis #REDIS host (not localhost because we use docker)
- REDIS_PASSWORD=null #Redis password (actually we do not use it )
- REDIS_PORT=6379 #Standart Redis port
- REDIS_EXTERNAL_PORT=6400 #Port to connect redis oustside the container
- REDIS_EXCHANGE_RATE_EX_TTL=86400 #TTL for saving actual currency course

- XDEBUG_REMOTE_HOST=host.docker.internal #Remote host for XDEBUG
- XDEBUG_REMOTE_PORT=19000 #Remote host for XDEBUG

- EXCHANGE_RATE_URL=https://api.exchangeratesapi.io/latest?base= #URL for getting actual course
- RUBLE_NAME=RUB #just not to hardcode
- DOLLAR_NAME=USD #just not to hardcode

# How it works

- Применяемые паттерны:
    - Заместитель (Proxy) https://refactoring.guru/ru/design-patterns/proxy
    - Стратегия (Strategy) https://refactoring.guru/ru/design-patterns/strategy
    - Null-объекта https://refactoring.guru/ru/introduce-null-object
    
- bootstrap.php
    - подключаем автозагрузку
    - подгружаем переменные окружения
    - получаем соединения для postgres и redis (закрываем в конце index.php)    
    - создаем таблицу в postgres (типа миграция)
    
- index.php

- ExchangeRateModel.php 
    - модель предметной области с которой работаем (она же выполняет роль DTO для Storage b Downloader), содержит:
        - baseCurrency : Валюта от которой расчитывается курс 
        - currentCurrency : Валюта на которуб рассчитывается курс
        - course : Курс
        - date : дата курса
- NullExchangeRateModel.php
    - Null объект для ExchangeRateModel
    
- Storage
    - инкапсулирует в себе работу по получению и сохранению курса валюты
    - является Стратегией для ProxyDownloader 
    - APIStorage получает курс по сети (метод set пустой)           
    - CacheStorage получает курс из кеша 
    - DatabaseStorage получает курс из бд
    
- Downloader и ProxyDownloader
    - реализуют Заместитель (Сервис реализует сам, можно обойтись и без интерфейса, но мы можем захотеть сделать Downloader без Storage)  
    - логика работы метода currentExchangeRate
        - получаеи модель из Storage (определенного для этого заместителя) 
        - если модель isNull, дергаем вложенный заместитель 
        - если модель, полученная из вложенного заместителя isNull возвращеам ее
        - если нет обновляем Storage и возвращаем модель
            

# TODO

- Tests
- Реализовать получение курса за любой день (пока только текущий) для APIStorage

#P.S.

Извиняюсь за грамматичские ошибки если они есть, и за то что все одним коммитом (увлекся) 