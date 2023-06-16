# app.loc-test_task
A repository with a simple implementation of a test task.

## Вимоги:
- git (потрібен для клонування проекту)
- docker та docker-compose
(проект може бути розгорнутий в любому середовищі яке підтримує використання docker)

## Структура проекту:
- Frontend (Vue.js [x.x])
- Backend (PHP [7.4])
- Database (MySQL [8.0])
- Webserver (Nginx [1.21])

## Файлова структура:
.
├── README.md
├── backend
│   ├── Dockerfile
│   ├── docker-entrypoint.sh
│   └── index.php
├── database
├── docker-compose-server.yml
├── docker-compose.yml
├── env.example
├── frontend
│   └── dist
│       └── index.html
└── nginx
    ├── certs
    └── conf
        └── nginx.conf

## Загальний опис:
Наш проект складається з фронтенду та бекенду. Бекенд на PHP виступає в ролі API, на основі якого фронтенд (Vue.js) генерує статичний контент. Для роботи використовується база данних MySQL (яка хоститься на цій же машині). Фронтенд та бекенд обслуговує Nginx - видає статику фронтенду по домену "app.loc", та як проксі на бекенд для "api.app.loc". Весь проект докеризований, та запускається однією командою docker-compose.

Передбачено два середовища розробки - на локальних машинах розробників, та в подальшому на dev сервері. Для розділення (можливо буде відрізнятися частина з сертифікатами тощо) є два docker-compose файли:
- docker-compose.yml -- для розробників (запуску на локальній машині)
- docker-compose-server.yml -- для розгортанні на сервері

## Інструкція з розгортання:
0. Передбачається що у вас встановлений і налаштований Git (https://git-scm.com/book/en/v2/Getting-Started-Installing-Git).
1. Встановіть Docker та docker-compose 
- (ubuntu: https://docs.docker.com/engine/install/ubuntu/) 
- (windows: https://docs.docker.com/desktop/install/windows-install/) 
- (macos: https://docs.docker.com/desktop/install/mac-install/)

3. Склонуйте репозиторій:
``` git clone https://github.com/tormoyader/app.loc-test_task.git ```
Або за допомогою ssh:
``` git clone git@github.com:tormoyader/app.loc-test_task.git ```

### For developers:
> Примітка: Оскільки конфігурація сайту *уявімо що* заточена під домени, ми використовуватимо їх і при локальній розробці. Тому пропонується прописати > наш домен в файлі hosts щоб ваша операційна система пересилала весь трафік який ви шлете на цей домен - назад на 127.0.0.1.
4. За допомогою текстового редактора, добавте ці рядки в файл hosts:
``` 
127.0.0.1       app.loc
127.0.0.1       api.app.loc 
```

Він знаходиться:
- Windwos: C:\Windows\System32\Drivers\etc
- Ubuntu: /etc/hosts
- OS X: /etc/hosts

5. Перейдіть у склоновану директорію проекту, та запустіть проект командою:
``` docker-compose up -d ```

### For DevOps:
4. Для роботи проекту потрібно прив'язати доменні імена app.loc і api.app.loc до IP адреси сервера. Після цього на час розробки можна обмежити доступ до сервера (шляхом внутрішнього фаєрволу по типу UFW чи зовнішнього по типу Security Groups в AWS чи DO). В даній реалізації немає роботи по HTTPS, але вона є виключно важливою (в випадку закриття доступу до сайту для зовнішнього світу, можна пройти верифікацію сертифікатів за допомогою DNS рекордів (DNS validation)). 

5. Перейдіть у склоновану директорію проекту, та запустіть проект командою:
``` docker-compose -f docker-compose-server.yml up -d ```

### Про контейнери і взаємодію з ними:
Оскільки на цьому етапі не передбачено маштабування, всім контейнерам присвоєні імена, відповідно до технологій. 
Назва компоненту | Назва контейнеру
- Frontend -> vue
- Backend -> php
- Webserwer -> nginx
- Database -> mysql

Щоб вимкнути всі контейнери (спершу потрібно відкрити директорію з проектом):
- docker-compose down 
або якщо на сервері:
- docker-compose -f docker-compose-server.yml down

Щоб глянути статус всіх контейнерів:
- docker ps -a

Щоб переглянути логи контейнеру:
- docker logs [container_name]

Щоб відкрити вміст контейнера або виконати команду всередині:
- docker exec -it [container_name] /bin/sh
- docker exec [container_name] [command]

### Офтоп (коментарі і нереалізовані ідеї):
В моїй реалізації frontend - максимально фейковий (в принципі як і весь проект, макет не більше). Наступними пунктами була б реалізація SSL(TLS) сертифікатів та зберігання чутливих даних в .env файлі. Крім того налаштування пайпланів для автоматичного розгортання в процесі розробки. 

В конфігурації docker-compose.yml варто задати обмеження по читання/писанню для волюмів (бо чим менші можливі права, тим краще [відчуваєте присмак диктатури?]).

Крім того як варіант використання контейнеру nginx-proxy(https://github.com/nginx-proxy/nginx-proxy) для полекшення взаємодії з Nginx.
