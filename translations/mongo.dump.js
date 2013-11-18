
/** translation indexes **/
db.getCollection("translation").ensureIndex({
  "_id": NumberInt(1)
},[
  
]);

/** translation indexes **/
db.getCollection("translation").ensureIndex({
  "category": NumberInt(1),
  "language": NumberInt(1),
  "message": NumberInt(1)
},{
  "unique": true
});

/** translation records **/
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000b1"),
  "category": "app",
  "language": "ru",
  "message": "Requested page not found",
  "translation": "Запрошенная страница не найдена"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000b0"),
  "category": "app",
  "language": "ru",
  "message": "Access forbidden",
  "translation": "Доступ запрещён"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000007"),
  "category": "app",
  "language": "uk",
  "message": "Additional data",
  "translation": "Додаткова інформація"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5242969d445798cc118b45e2"),
  "category": "app",
  "language": "uk",
  "message": "No news yet.",
  "translation": "Немає жодних новин."
});
db.getCollection("translation").insert({
  "_id": ObjectId("5242969d445798cc118b45d8"),
  "category": "app",
  "language": "uk",
  "message": "I agree with rules of the service",
  "translation": "Я згоден с умовами сервісу"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5242969d445798cc118b45a2"),
  "category": "app",
  "language": "uk",
  "message": "The recaptcha code is incorrect.",
  "translation": "Невірній код."
});
db.getCollection("translation").insert({
  "_id": ObjectId("5242969d445798cc118b45a0"),
  "category": "app",
  "language": "uk",
  "message": "Related user ID",
  "translation": "ID пов'язаного користувача"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5242969d445798cc118b466f"),
  "category": "app",
  "language": "ru",
  "message": "No news yet.",
  "translation": "Пока нет новостей."
});
db.getCollection("translation").insert({
  "_id": ObjectId("5242969d445798cc118b462f"),
  "category": "app",
  "language": "ru",
  "message": "The recaptcha code is incorrect.",
  "translation": "Код капчи неверен."
});
db.getCollection("translation").insert({
  "_id": ObjectId("5227261873bda4044b00012b"),
  "category": "app",
  "language": "en",
  "message": "2nd Phase Results",
  "translation": "2nd Stage Results"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5227261873bda4044b00012c"),
  "category": "app",
  "language": "en",
  "message": "3d Phase Results",
  "translation": "3rd Stage Results"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b4601"),
  "category": "app",
  "language": "uk",
  "message": "Zaporizhia",
  "translation": "Запоріжжя"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b4600"),
  "category": "app",
  "language": "uk",
  "message": "Zakarpattia",
  "translation": "Закарпаття"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b45fe"),
  "category": "app",
  "language": "uk",
  "message": "Vinnytsia",
  "translation": "Вінниця"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b45fd"),
  "category": "app",
  "language": "uk",
  "message": "Ternopil",
  "translation": "Тернопіль"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b45fa"),
  "category": "app",
  "language": "uk",
  "message": "Poltava",
  "translation": "Полтава"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b45f9"),
  "category": "app",
  "language": "uk",
  "message": "Odessa",
  "translation": "Одеса"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b45f8"),
  "category": "app",
  "language": "uk",
  "message": "Mykolaiv",
  "translation": "Миколаїв"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b45f6"),
  "category": "app",
  "language": "uk",
  "message": "Luhansk",
  "translation": "Луганськ"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b45f5"),
  "category": "app",
  "language": "uk",
  "message": "Kirovohrad",
  "translation": "Кіровоград"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b45f3"),
  "category": "app",
  "language": "uk",
  "message": "Khmelnytskyi",
  "translation": "Хмельницький"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b45f2"),
  "category": "app",
  "language": "uk",
  "message": "Kherson",
  "translation": "Херсон"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b45f1"),
  "category": "app",
  "language": "uk",
  "message": "Kharkiv",
  "translation": "Харків"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b45f0"),
  "category": "app",
  "language": "uk",
  "message": "Ivano-Frankivsk",
  "translation": "Івано-Франківськ"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b45ef"),
  "category": "app",
  "language": "uk",
  "message": "Donetsk",
  "translation": "Донецьк"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b45ee"),
  "category": "app",
  "language": "uk",
  "message": "Dnipropetrovsk",
  "translation": "Дніпропетрвоськ"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b45ed"),
  "category": "app",
  "language": "uk",
  "message": "Chernivtsi",
  "translation": "Чернівці"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b45ec"),
  "category": "app",
  "language": "uk",
  "message": "Chernihiv",
  "translation": "Чернігів"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b45eb"),
  "category": "app",
  "language": "uk",
  "message": "Cherkasy",
  "translation": "Черкаси"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b45e9"),
  "category": "app",
  "language": "uk",
  "message": "State",
  "translation": "Область"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b45e5"),
  "category": "app",
  "language": "uk",
  "message": "East",
  "translation": "Північ"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b45e4"),
  "category": "app",
  "language": "uk",
  "message": "Center",
  "translation": "Центр"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b45e3"),
  "category": "app",
  "language": "uk",
  "message": "Region",
  "translation": "Регіон"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b45e2"),
  "category": "app",
  "language": "uk",
  "message": "Ukraine",
  "translation": "Україна"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b45e1"),
  "category": "app",
  "language": "uk",
  "message": "Coordinator",
  "translation": "Координатор"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b45e0"),
  "category": "app",
  "language": "uk",
  "message": "I'm a coach",
  "translation": "Тренер"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b45b9"),
  "category": "app",
  "language": "uk",
  "message": "Activate",
  "translation": "Активувати"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5253c844445798cd448b45ba"),
  "category": "app",
  "language": "uk",
  "message": "Preview",
  "translation": "Переглянути"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b45ba"),
  "category": "app",
  "language": "uk",
  "message": "Suspend",
  "translation": "Призупинити"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5253c844445798cd448b45bb"),
  "category": "app",
  "language": "uk",
  "message": "Upload images here",
  "translation": "Завантажити картинки тут"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500003a"),
  "category": "app",
  "language": "uk",
  "message": "Unknown identity",
  "translation": "Невідома сутність"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b46ba"),
  "category": "app",
  "language": "ru",
  "message": "Zakarpattia",
  "translation": "Закарпатье"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b46b4"),
  "category": "app",
  "language": "ru",
  "message": "Poltava",
  "translation": "Полтава"
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Answer count",
  "translation": "Количество ответов",
  "_id": ObjectId("5260e6a9445798b6048b469b")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Date of birth",
  "translation": "Дата рождения",
  "_id": ObjectId("5260e6a9445798b6048b46e1")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "First name in Ukrainian",
  "translation": "Имя на украинском",
  "_id": ObjectId("5289cb7d44579889608b475b")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Roles",
  "translation": "Роли",
  "_id": ObjectId("5289cb7d44579889608b4836")
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b48cf"),
  "category": "app",
  "language": "en",
  "message": "{attr} cannot be empty",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b48d7"),
  "category": "app",
  "language": "en",
  "message": "First name in Ukrainian",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b48ef"),
  "category": "app",
  "language": "en",
  "message": "School name",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b48f1"),
  "category": "app",
  "language": "en",
  "message": "Division",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000108"),
  "category": "app",
  "language": "en",
  "message": "Cannot add \"{child}\" as a child of \"{parent}\". A loop has been detected.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500010b"),
  "category": "app",
  "language": "en",
  "message": "Authorization item \"{item}\" has already been assigned to user \"{user}\".",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500010c"),
  "category": "app",
  "language": "en",
  "message": "Unable to add an item whose name is the same as an existing item.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500010d"),
  "category": "app",
  "language": "en",
  "message": "Unable to change the item name. The name \"{name}\" is already used by another item.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000134"),
  "category": "app",
  "language": "en",
  "message": "Password is invalid",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500013a"),
  "category": "app",
  "language": "en",
  "message": "{app} - Languages",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500013e"),
  "category": "app",
  "language": "en",
  "message": "Message translations",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500013f"),
  "category": "app",
  "language": "en",
  "message": "Update translation messages",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500004b"),
  "category": "app",
  "language": "uk",
  "message": "Save News",
  "translation": "Зберегти новину"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000c5"),
  "category": "app",
  "language": "ru",
  "message": "News",
  "translation": "Новости"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000049"),
  "category": "app",
  "language": "uk",
  "message": "News",
  "translation": "Новини"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500005b"),
  "category": "app",
  "language": "uk",
  "message": "Docs",
  "translation": "Документи"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000023"),
  "category": "app",
  "language": "uk",
  "message": "Regulations",
  "translation": "Нормативні"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500009f"),
  "category": "app",
  "language": "ru",
  "message": "Regulations",
  "translation": "Нормативные"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000022"),
  "category": "app",
  "language": "uk",
  "message": "Guidance",
  "translation": "Методичні"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000061"),
  "category": "app",
  "language": "uk",
  "message": "Logout",
  "translation": "Вихід"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000dd"),
  "category": "app",
  "language": "ru",
  "message": "Logout",
  "translation": "Выход"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000001"),
  "category": "app",
  "language": "uk",
  "message": "Language",
  "translation": "Мова"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000096"),
  "category": "app",
  "language": "ru",
  "message": "Metadata",
  "translation": "Метадата"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000d5"),
  "category": "app",
  "language": "ru",
  "message": "Ukranian Collegiate Programming Contest",
  "translation": "Всеукраинская студенческая олимпиада по программированию"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000029"),
  "category": "app",
  "language": "uk",
  "message": "Upload is completed",
  "translation": "Завантаження завершено"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000028"),
  "category": "app",
  "language": "uk",
  "message": "File unique ID",
  "translation": "Унікальний ID файлу"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000021"),
  "category": "app",
  "language": "uk",
  "message": "Registration date",
  "translation": "Дата реєстрації"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000020"),
  "category": "app",
  "language": "uk",
  "message": "Is published",
  "translation": "Опубліковано"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500001f"),
  "category": "app",
  "language": "uk",
  "message": "File extension",
  "translation": "Розширення файлу"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500001c"),
  "category": "app",
  "language": "uk",
  "message": "Title",
  "translation": "Заголовок"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500001a"),
  "category": "app",
  "language": "uk",
  "message": "Metadata",
  "translation": "Метадата"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000018"),
  "category": "app",
  "language": "uk",
  "message": "Unknown operation.",
  "translation": "Невідома операція."
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000016"),
  "category": "app",
  "language": "uk",
  "message": "Membership.",
  "translation": "Учасник."
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500000a"),
  "category": "app",
  "language": "uk",
  "message": "Description",
  "translation": "Опис"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500002d"),
  "category": "app",
  "language": "uk",
  "message": "Password hash",
  "translation": "Хеш пароля"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000034"),
  "category": "app",
  "language": "uk",
  "message": "Access forbidden",
  "translation": "Доступ заборонено"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000035"),
  "category": "app",
  "language": "uk",
  "message": "Requested page not found",
  "translation": "Сторінку не знайдено"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000036"),
  "category": "app",
  "language": "uk",
  "message": "Unknown error",
  "translation": "Невідома помилка"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500003d"),
  "category": "app",
  "language": "uk",
  "message": "Document",
  "translation": "Документ"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500003f"),
  "category": "app",
  "language": "uk",
  "message": "Uploaded",
  "translation": "Завантажено"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000041"),
  "category": "app",
  "language": "uk",
  "message": "Save Document",
  "translation": "Зберегти документ"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000042"),
  "category": "app",
  "language": "uk",
  "message": "{app} - Languages",
  "translation": "{app} - Мови"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000047"),
  "category": "app",
  "language": "uk",
  "message": "Update translation messages",
  "translation": "Оновити переклади"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5227261873bda4044b000157"),
  "category": "app",
  "language": "en",
  "message": "Edit News",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5227261873bda4044b00017a"),
  "category": "app",
  "language": "en",
  "message": "Requested news has no translation in {lang}",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5227261873bda4044b00017b"),
  "category": "app",
  "language": "en",
  "message": "Find it out in other languages",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5227261873bda4044b00017d"),
  "category": "app",
  "language": "en",
  "message": "Upload Results",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5227261873bda4044b00017e"),
  "category": "app",
  "language": "en",
  "message": "No results.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500003b"),
  "category": "app",
  "language": "uk",
  "message": "E-mail is invalid",
  "translation": "Невірний email"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500003c"),
  "category": "app",
  "language": "uk",
  "message": "Password is invalid",
  "translation": "Невірний пароль"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000066"),
  "category": "app",
  "language": "uk",
  "message": "Password",
  "translation": "Пароль"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000068"),
  "category": "app",
  "language": "uk",
  "message": "register",
  "translation": "реєстрація"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000069"),
  "category": "app",
  "language": "uk",
  "message": "Signup",
  "translation": "Зареєструватися"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500006e"),
  "category": "app",
  "language": "uk",
  "message": "Repeat password",
  "translation": "Пароль ще раз"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500006f"),
  "category": "app",
  "language": "uk",
  "message": "Sign up",
  "translation": "Зареєструватися"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000071"),
  "category": "app",
  "language": "uk",
  "message": "Upload Doc",
  "translation": "Завантажити документ"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000075"),
  "category": "app",
  "language": "uk",
  "message": "Edit",
  "translation": "Редагувати"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000076"),
  "category": "app",
  "language": "uk",
  "message": "Older",
  "translation": "Попередні"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500007a"),
  "category": "app",
  "language": "uk",
  "message": "Publish",
  "translation": "Опублікувати"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500007b"),
  "category": "app",
  "language": "uk",
  "message": "Hide",
  "translation": "Сховати"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5227261873bda4044b000024"),
  "category": "app",
  "language": "uk",
  "message": "1st Phase Results",
  "translation": "Результати 1 етапу"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5227261873bda4044b000025"),
  "category": "app",
  "language": "uk",
  "message": "2nd Phase Results",
  "translation": "Результати 2 етапу"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5227261873bda4044b000027"),
  "category": "app",
  "language": "uk",
  "message": "Common ID",
  "translation": "Спільний ІН"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5227261873bda4044b000059"),
  "category": "app",
  "language": "uk",
  "message": "Results",
  "translation": "Результати"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000000"),
  "category": "app",
  "language": "uk",
  "message": "Category",
  "translation": "Категорія"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5227261873bda4044b000026"),
  "category": "app",
  "language": "uk",
  "message": "3d Phase Results",
  "translation": "Результати 3 етапу"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5227261873bda4044b000077"),
  "category": "app",
  "language": "uk",
  "message": "Upload Results",
  "translation": "Завантажити результати"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5227261873bda4044b000078"),
  "category": "app",
  "language": "uk",
  "message": "No results.",
  "translation": "Немає результатів."
});
db.getCollection("translation").insert({
  "_id": ObjectId("5227261873bda4044b0000a7"),
  "category": "app",
  "language": "ru",
  "message": "1st Phase Results",
  "translation": "Результаты 1 этапа"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5227261873bda4044b0000a8"),
  "category": "app",
  "language": "ru",
  "message": "2nd Phase Results",
  "translation": "Результаты 2 этапа"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5227261873bda4044b0000a9"),
  "category": "app",
  "language": "ru",
  "message": "3d Phase Results",
  "translation": "Результаты 3 этапа"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5227261873bda4044b0000d4"),
  "category": "app",
  "language": "ru",
  "message": "Edit News",
  "translation": "Редактировать новость"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500007c"),
  "category": "app",
  "language": "ru",
  "message": "Category",
  "translation": "Категория"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500007e"),
  "category": "app",
  "language": "ru",
  "message": "Message",
  "translation": "Сообщение"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500007f"),
  "category": "app",
  "language": "ru",
  "message": "Translation",
  "translation": "Перевод"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000080"),
  "category": "app",
  "language": "ru",
  "message": "Item name",
  "translation": "Имя элемента"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000081"),
  "category": "app",
  "language": "ru",
  "message": "User ID",
  "translation": "ID пользователя"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000082"),
  "category": "app",
  "language": "ru",
  "message": "Business rule",
  "translation": "Бизнес правило"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000083"),
  "category": "app",
  "language": "ru",
  "message": "Additional data",
  "translation": "Дополнительная информация"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000092"),
  "category": "app",
  "language": "ru",
  "message": "Membership.",
  "translation": "Участники."
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000094"),
  "category": "app",
  "language": "ru",
  "message": "Unknown operation.",
  "translation": "Неизвестная операция."
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000098"),
  "category": "app",
  "language": "ru",
  "message": "Title",
  "translation": "Заголовок"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500009b"),
  "category": "app",
  "language": "ru",
  "message": "File extension",
  "translation": "Расширение файла"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500009c"),
  "category": "app",
  "language": "ru",
  "message": "Is published",
  "translation": "Опубликовано"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500009d"),
  "category": "app",
  "language": "ru",
  "message": "Registration date",
  "translation": "Дата регистрации"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000a1"),
  "category": "app",
  "language": "ru",
  "message": "Content",
  "translation": "Контент"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000a5"),
  "category": "app",
  "language": "ru",
  "message": "Upload is completed",
  "translation": "Загрузка завершена"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000a8"),
  "category": "app",
  "language": "ru",
  "message": "Email",
  "translation": "Email"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000a9"),
  "category": "app",
  "language": "ru",
  "message": "Password hash",
  "translation": "Хеш пароля"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000ba"),
  "category": "app",
  "language": "ru",
  "message": "Upload",
  "translation": "Загрузить"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000bb"),
  "category": "app",
  "language": "ru",
  "message": "Uploaded",
  "translation": "Загружено"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000bd"),
  "category": "app",
  "language": "ru",
  "message": "Save Document",
  "translation": "Сохранить документ"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000bf"),
  "category": "app",
  "language": "ru",
  "message": "Lang",
  "translation": "Язык"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000c2"),
  "category": "app",
  "language": "ru",
  "message": "Message translations",
  "translation": "Перевод"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000c4"),
  "category": "app",
  "language": "ru",
  "message": "Update",
  "translation": "Обновить"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000da"),
  "category": "app",
  "language": "ru",
  "message": "Langs",
  "translation": "Языки"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000db"),
  "category": "app",
  "language": "ru",
  "message": "Login",
  "translation": "Войти"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000dc"),
  "category": "app",
  "language": "ru",
  "message": "Hello",
  "translation": "Привет"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000e2"),
  "category": "app",
  "language": "ru",
  "message": "Password",
  "translation": "Пароль"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000e3"),
  "category": "app",
  "language": "ru",
  "message": "Sign in",
  "translation": "Войти"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000e4"),
  "category": "app",
  "language": "ru",
  "message": "register",
  "translation": "регистрация"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000e5"),
  "category": "app",
  "language": "ru",
  "message": "Signup",
  "translation": "Зарегистрироваться"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000ea"),
  "category": "app",
  "language": "ru",
  "message": "Repeat password",
  "translation": "Пароль ещё раз"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000eb"),
  "category": "app",
  "language": "ru",
  "message": "Sign up",
  "translation": "Зарегистрироваться"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000f1"),
  "category": "app",
  "language": "ru",
  "message": "Edit",
  "translation": "Редактировать"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5227261873bda4044b000051"),
  "category": "app",
  "language": "uk",
  "message": "Edit News",
  "translation": "Редагувати новини"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000003"),
  "category": "app",
  "language": "uk",
  "message": "Translation",
  "translation": "Переклад"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5227261873bda4044b0000fb"),
  "category": "app",
  "language": "ru",
  "message": "No results.",
  "translation": "Нет результатов."
});
db.getCollection("translation").insert({
  "_id": ObjectId("5227261873bda4044b0000fa"),
  "category": "app",
  "language": "ru",
  "message": "Upload Results",
  "translation": "Загрузить результаты"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5227261873bda4044b0000f8"),
  "category": "app",
  "language": "ru",
  "message": "Find it out in other languages",
  "translation": "Найти на других языках"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5253c844445798cd448b46d5"),
  "category": "app",
  "language": "en",
  "message": "Upload images here",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5253c844445798cd448b470e"),
  "category": "appjs",
  "language": "en",
  "message": "You have unsaved changes.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b45b8"),
  "category": "app",
  "language": "uk",
  "message": "Action",
  "translation": "Дія"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000078"),
  "category": "app",
  "language": "uk",
  "message": "Inbox",
  "translation": "Вхідні"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b46ae"),
  "category": "app",
  "language": "ru",
  "message": "Kiev",
  "translation": "Киев"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000a4"),
  "category": "app",
  "language": "ru",
  "message": "File unique ID",
  "translation": "Уникальный ИН файла"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b4672"),
  "category": "app",
  "language": "ru",
  "message": "Action",
  "translation": "Действие"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b475d"),
  "category": "app",
  "language": "en",
  "message": "State",
  "translation": "Subregion"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5256cb1344579885588b45e4"),
  "category": "app",
  "language": "uk",
  "message": "Create News",
  "translation": "Додати новину"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5256cb1344579885588b467d"),
  "category": "app",
  "language": "ru",
  "message": "Coordination type",
  "translation": "Тип координатора"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5227261873bda4044b0000dc"),
  "category": "app",
  "language": "ru",
  "message": "Results",
  "translation": "Результаты"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000f7"),
  "category": "app",
  "language": "ru",
  "message": "Hide",
  "translation": "Скрыть"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000f6"),
  "category": "app",
  "language": "ru",
  "message": "Publish",
  "translation": "Опубликовать"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000f4"),
  "category": "app",
  "language": "ru",
  "message": "Inbox",
  "translation": "Входящие"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000f3"),
  "category": "app",
  "language": "ru",
  "message": "Newer",
  "translation": "Следующие"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000f2"),
  "category": "app",
  "language": "ru",
  "message": "Older",
  "translation": "Предыдущие"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000b9"),
  "category": "app",
  "language": "ru",
  "message": "Document",
  "translation": "Документ"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000b8"),
  "category": "app",
  "language": "ru",
  "message": "Password is invalid",
  "translation": "Неверный пароль"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000b7"),
  "category": "app",
  "language": "ru",
  "message": "E-mail is invalid",
  "translation": "Неверный email"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000b6"),
  "category": "app",
  "language": "ru",
  "message": "Unknown identity",
  "translation": "Неизвестная сущность"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000b2"),
  "category": "app",
  "language": "ru",
  "message": "Unknown error",
  "translation": "Неизвестная ошибка"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000086"),
  "category": "app",
  "language": "ru",
  "message": "Description",
  "translation": "Описание"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000085"),
  "category": "app",
  "language": "ru",
  "message": "Name",
  "translation": "Имя"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5227261873bda4044b000075"),
  "category": "app",
  "language": "uk",
  "message": "Find it out in other languages",
  "translation": "Знайдіть на іншій мові"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000006"),
  "category": "app",
  "language": "uk",
  "message": "Business rule",
  "translation": "Бізнес правило"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000002"),
  "category": "app",
  "language": "uk",
  "message": "Message",
  "translation": "Повідомлення"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000005"),
  "category": "app",
  "language": "uk",
  "message": "User ID",
  "translation": "ID користувача"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5242969d445798cc118b46ba"),
  "category": "app",
  "language": "en",
  "message": "Related user ID",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5242969d445798cc118b46bc"),
  "category": "app",
  "language": "en",
  "message": "The recaptcha code is incorrect.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5242969d445798cc118b46bd"),
  "category": "app",
  "language": "en",
  "message": "Please, read and accept service rules",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5242969d445798cc118b46f0"),
  "category": "app",
  "language": "en",
  "message": "I'm a student",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5242969d445798cc118b46f2"),
  "category": "app",
  "language": "en",
  "message": "I agree with rules of the service",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5242969d445798cc118b46fc"),
  "category": "app",
  "language": "en",
  "message": "No news yet.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5242969d445798cc118b45d6"),
  "category": "app",
  "language": "uk",
  "message": "I'm a student",
  "translation": "Студент"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000004"),
  "category": "app",
  "language": "uk",
  "message": "Item name",
  "translation": "Ім'я елементу"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5242969d445798cc118b4663"),
  "category": "app",
  "language": "ru",
  "message": "I'm a student",
  "translation": "Студент"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5227261873bda4044b00012a"),
  "category": "app",
  "language": "en",
  "message": "1st Phase Results",
  "translation": "1st Stage Results"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b472d"),
  "category": "app",
  "language": "en",
  "message": "Activate",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b4755"),
  "category": "app",
  "language": "en",
  "message": "Coordinator",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b4602"),
  "category": "app",
  "language": "uk",
  "message": "Zhytomyr",
  "translation": "Житомир"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b45ff"),
  "category": "app",
  "language": "uk",
  "message": "Volyn",
  "translation": "Волинь"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b45e7"),
  "category": "app",
  "language": "uk",
  "message": "South",
  "translation": "Схід"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b46b1"),
  "category": "app",
  "language": "ru",
  "message": "Lviv",
  "translation": "Львов"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b46a4"),
  "category": "app",
  "language": "ru",
  "message": "ARC",
  "translation": "АРК"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b46a2"),
  "category": "app",
  "language": "ru",
  "message": "West",
  "translation": "Запад"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b46a1"),
  "category": "app",
  "language": "ru",
  "message": "South",
  "translation": "Юг"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5256cb1344579885588b47a2"),
  "category": "app",
  "language": "en",
  "message": "Create News",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b475e"),
  "category": "app",
  "language": "en",
  "message": "Use setView() method instead of this one.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b478f"),
  "category": "app",
  "language": "en",
  "message": "Question ID",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b4795"),
  "category": "app",
  "language": "en",
  "message": "Assigned tags",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b4796"),
  "category": "app",
  "language": "en",
  "message": "Answer count",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b47d3"),
  "category": "app",
  "language": "en",
  "message": "Position",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b47d4"),
  "category": "app",
  "language": "en",
  "message": "Office address",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b47d6"),
  "category": "app",
  "language": "en",
  "message": "Fax number",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b47d7"),
  "category": "app",
  "language": "en",
  "message": "Field of study",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b47dc"),
  "category": "app",
  "language": "en",
  "message": "Date of birth",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b47e3"),
  "category": "app",
  "language": "en",
  "message": "Password reset",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b481f"),
  "category": "app",
  "language": "en",
  "message": "Reset password",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b482a"),
  "category": "app",
  "language": "en",
  "message": "Resend token",
  "translation": ""
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Date",
  "translation": "Дата",
  "_id": ObjectId("5260e6a9445798b6048b46e4")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Question ID",
  "translation": "ІН питання",
  "_id": ObjectId("5260e6a9445798b6048b4599")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Desc",
  "translation": "Опис",
  "_id": ObjectId("5260e6a9445798b6048b45a3")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Group",
  "translation": "Група",
  "_id": ObjectId("5260e6a9445798b6048b45e4")
});
db.getCollection("translation").insert({
  "_id": ObjectId("52677c8a445798ab308b482c"),
  "category": "app",
  "language": "en",
  "message": "Users",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52677c8a445798ab308b482e"),
  "category": "app",
  "language": "en",
  "message": "Coaches",
  "translation": ""
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Date date",
  "translation": "Дата",
  "_id": ObjectId("52720676445798e6728b45b8")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "School",
  "translation": "ВНЗ",
  "_id": ObjectId("52720676445798e6728b45d6")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Year date",
  "translation": "Год",
  "_id": ObjectId("52720677445798e6728b46ce")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Date date",
  "translation": "Дата",
  "_id": ObjectId("52720677445798e6728b46cf")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "School",
  "translation": "ВУЗ",
  "_id": ObjectId("52720677445798e6728b46ed")
});
db.getCollection("translation").insert({
  "_id": ObjectId("52720677445798e6728b47be"),
  "category": "app",
  "language": "en",
  "message": "Unknown region name.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52720677445798e6728b47bf"),
  "category": "app",
  "language": "en",
  "message": "Region name",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52720677445798e6728b4804"),
  "category": "app",
  "language": "en",
  "message": "School",
  "translation": ""
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Year",
  "translation": "Рік",
  "_id": ObjectId("5289cb7d44579889608b4609")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "year",
  "translation": "рік",
  "_id": ObjectId("5289cb7d44579889608b4642")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Roles",
  "translation": "Ролі",
  "_id": ObjectId("5289cb7d44579889608b46ba")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Geo",
  "translation": "Гео",
  "_id": ObjectId("5289cb7d44579889608b4733")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Year",
  "translation": "Год",
  "_id": ObjectId("5289cb7d44579889608b4785")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "year",
  "translation": "год",
  "_id": ObjectId("5289cb7d44579889608b47be")
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b48c8"),
  "category": "app",
  "language": "en",
  "message": "Name of a team",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b48ca"),
  "category": "app",
  "language": "en",
  "message": "Related coach ID",
  "translation": ""
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Fax number",
  "translation": "Факс",
  "_id": ObjectId("5260e6a9445798b6048b46db")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Region name",
  "translation": "Название региона",
  "_id": ObjectId("52720677445798e6728b46a8")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Field of study",
  "translation": "Спеціальність",
  "_id": ObjectId("5260e6a9445798b6048b45e1")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Save",
  "translation": "Зберегти",
  "_id": ObjectId("5289cb7d44579889608b464b")
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500012a"),
  "category": "app",
  "language": "en",
  "message": "{attr} length should be greater or equal than {val}.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500012b"),
  "category": "app",
  "language": "en",
  "message": "{controller} has an extra endWidget({id}) call in its view.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000c7"),
  "category": "app",
  "language": "ru",
  "message": "Save News",
  "translation": "Сохранить новость"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000f0"),
  "category": "app",
  "language": "ru",
  "message": "Add News",
  "translation": "Добавить новость"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000070"),
  "category": "app",
  "language": "uk",
  "message": "Guidance docs",
  "translation": "Методичні документи"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000072"),
  "category": "app",
  "language": "uk",
  "message": "Regulation docs",
  "translation": "Нормативні документи"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000d7"),
  "category": "app",
  "language": "ru",
  "message": "Docs",
  "translation": "Документы"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000ec"),
  "category": "app",
  "language": "ru",
  "message": "Guidance docs",
  "translation": "Методические документы"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000ee"),
  "category": "app",
  "language": "ru",
  "message": "Regulation docs",
  "translation": "Нормативные документы"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500009e"),
  "category": "app",
  "language": "ru",
  "message": "Guidance",
  "translation": "Методические"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000067"),
  "category": "app",
  "language": "uk",
  "message": "Sign in",
  "translation": "Увійти"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000060"),
  "category": "app",
  "language": "uk",
  "message": "Hello",
  "translation": "Привіт"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500005f"),
  "category": "app",
  "language": "uk",
  "message": "Login",
  "translation": "Увійти"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000048"),
  "category": "app",
  "language": "uk",
  "message": "Update",
  "translation": "Оновити"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000046"),
  "category": "app",
  "language": "uk",
  "message": "Message translations",
  "translation": "Переклади"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500003e"),
  "category": "app",
  "language": "uk",
  "message": "Upload",
  "translation": "Завантажити"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000031"),
  "category": "app",
  "language": "uk",
  "message": "{attr} is not confirmed.",
  "translation": "{attr} не підтверджено."
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500002a"),
  "category": "app",
  "language": "uk",
  "message": "First name",
  "translation": "Ім'я"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000025"),
  "category": "app",
  "language": "uk",
  "message": "Content",
  "translation": "Контент"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500007d"),
  "category": "app",
  "language": "ru",
  "message": "Language",
  "translation": "Язык"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500009a"),
  "category": "app",
  "language": "ru",
  "message": "Type",
  "translation": "Тип"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000a6"),
  "category": "app",
  "language": "ru",
  "message": "First name",
  "translation": "Имя"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b46bc"),
  "category": "app",
  "language": "ru",
  "message": "Zhytomyr",
  "translation": "Житорми"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b46bb"),
  "category": "app",
  "language": "ru",
  "message": "Zaporizhia",
  "translation": "Запорожье"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b46b9"),
  "category": "app",
  "language": "ru",
  "message": "Volyn",
  "translation": "Волынь"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b46b8"),
  "category": "app",
  "language": "ru",
  "message": "Vinnytsia",
  "translation": "Винница"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b46b7"),
  "category": "app",
  "language": "ru",
  "message": "Ternopil",
  "translation": "Тернополь"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b46b6"),
  "category": "app",
  "language": "ru",
  "message": "Sumy",
  "translation": "Суммы"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5227261873bda4044b0000aa"),
  "category": "app",
  "language": "ru",
  "message": "Common ID",
  "translation": "Общий ИН"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000f8"),
  "category": "app",
  "language": "en",
  "message": "Category",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000f9"),
  "category": "app",
  "language": "en",
  "message": "Language",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000fa"),
  "category": "app",
  "language": "en",
  "message": "Message",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000fb"),
  "category": "app",
  "language": "en",
  "message": "Translation",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000fc"),
  "category": "app",
  "language": "en",
  "message": "Item name",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000fd"),
  "category": "app",
  "language": "en",
  "message": "User ID",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000fe"),
  "category": "app",
  "language": "en",
  "message": "Business rule",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000ff"),
  "category": "app",
  "language": "en",
  "message": "Additional data",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000100"),
  "category": "app",
  "language": "en",
  "message": "Type of auth item",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000101"),
  "category": "app",
  "language": "en",
  "message": "Name",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000102"),
  "category": "app",
  "language": "en",
  "message": "Description",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000105"),
  "category": "app",
  "language": "en",
  "message": "List of children",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000106"),
  "category": "app",
  "language": "en",
  "message": "Children can not containt item name.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000107"),
  "category": "app",
  "language": "en",
  "message": "Either \"{name}\" or \"{child}\" does not exist.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000109"),
  "category": "app",
  "language": "en",
  "message": "The item \"{parent}\" already has a child \"{child}\".",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500010a"),
  "category": "app",
  "language": "en",
  "message": "Unknown authorization item \"{name}\".",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500010e"),
  "category": "app",
  "language": "en",
  "message": "Membership.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500010f"),
  "category": "app",
  "language": "en",
  "message": "View Facebook profile basic information.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000110"),
  "category": "app",
  "language": "en",
  "message": "Unknown operation.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000111"),
  "category": "app",
  "language": "en",
  "message": "The EMongoDocument cannot be deleted because it is new.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000112"),
  "category": "app",
  "language": "en",
  "message": "Metadata",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000113"),
  "category": "app",
  "language": "en",
  "message": "{attribute} is not unique in DB.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000114"),
  "category": "app",
  "language": "en",
  "message": "Title",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000116"),
  "category": "app",
  "language": "en",
  "message": "Type",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000117"),
  "category": "app",
  "language": "en",
  "message": "File extension",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000118"),
  "category": "app",
  "language": "en",
  "message": "Is published",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000119"),
  "category": "app",
  "language": "en",
  "message": "Registration date",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500011a"),
  "category": "app",
  "language": "en",
  "message": "Guidance",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500011b"),
  "category": "app",
  "language": "en",
  "message": "Regulations",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500011d"),
  "category": "app",
  "language": "en",
  "message": "Content",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000120"),
  "category": "app",
  "language": "en",
  "message": "File unique ID",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000121"),
  "category": "app",
  "language": "en",
  "message": "Upload is completed",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000122"),
  "category": "app",
  "language": "en",
  "message": "First name",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000124"),
  "category": "app",
  "language": "en",
  "message": "Email",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000125"),
  "category": "app",
  "language": "en",
  "message": "Password hash",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000128"),
  "category": "app",
  "language": "en",
  "message": "{attr} length should be less or equal than {val}.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000129"),
  "category": "app",
  "language": "en",
  "message": "{attr} is not confirmed.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500012c"),
  "category": "app",
  "language": "en",
  "message": "Access forbidden",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500012d"),
  "category": "app",
  "language": "en",
  "message": "Requested page not found",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500012e"),
  "category": "app",
  "language": "en",
  "message": "Unknown error",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500012f"),
  "category": "app",
  "language": "en",
  "message": "Failed to move uploaded file.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000130"),
  "category": "app",
  "language": "en",
  "message": "Failed to open input stream.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000131"),
  "category": "app",
  "language": "en",
  "message": "Failed to open output stream.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000132"),
  "category": "app",
  "language": "en",
  "message": "Unknown identity",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000133"),
  "category": "app",
  "language": "en",
  "message": "E-mail is invalid",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000135"),
  "category": "app",
  "language": "en",
  "message": "Document",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000136"),
  "category": "app",
  "language": "en",
  "message": "Upload",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000137"),
  "category": "app",
  "language": "en",
  "message": "Uploaded",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000139"),
  "category": "app",
  "language": "en",
  "message": "Save Document",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500013b"),
  "category": "app",
  "language": "en",
  "message": "Lang",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000140"),
  "category": "app",
  "language": "en",
  "message": "Update",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000141"),
  "category": "app",
  "language": "en",
  "message": "News",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000143"),
  "category": "app",
  "language": "en",
  "message": "Save News",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000151"),
  "category": "app",
  "language": "en",
  "message": "Ukranian Collegiate Programming Contest",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000153"),
  "category": "app",
  "language": "en",
  "message": "Docs",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000156"),
  "category": "app",
  "language": "en",
  "message": "Langs",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000157"),
  "category": "app",
  "language": "en",
  "message": "Login",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000158"),
  "category": "app",
  "language": "en",
  "message": "Hello",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000159"),
  "category": "app",
  "language": "en",
  "message": "Logout",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500015e"),
  "category": "app",
  "language": "en",
  "message": "Password",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500015f"),
  "category": "app",
  "language": "en",
  "message": "Sign in",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000160"),
  "category": "app",
  "language": "en",
  "message": "register",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000161"),
  "category": "app",
  "language": "en",
  "message": "Signup",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000166"),
  "category": "app",
  "language": "en",
  "message": "Repeat password",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000167"),
  "category": "app",
  "language": "en",
  "message": "Sign up",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000168"),
  "category": "app",
  "language": "en",
  "message": "Guidance docs",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000169"),
  "category": "app",
  "language": "en",
  "message": "Upload Doc",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500016a"),
  "category": "app",
  "language": "en",
  "message": "Regulation docs",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500016c"),
  "category": "app",
  "language": "en",
  "message": "Add News",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500016d"),
  "category": "app",
  "language": "en",
  "message": "Edit",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500016e"),
  "category": "app",
  "language": "en",
  "message": "Older",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500016f"),
  "category": "app",
  "language": "en",
  "message": "Newer",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000170"),
  "category": "app",
  "language": "en",
  "message": "Inbox",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000172"),
  "category": "app",
  "language": "en",
  "message": "Publish",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000173"),
  "category": "app",
  "language": "en",
  "message": "Hide",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000be"),
  "category": "app",
  "language": "ru",
  "message": "{app} - Languages",
  "translation": "{app} - Переводы"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000074"),
  "category": "app",
  "language": "uk",
  "message": "Add News",
  "translation": "Додати новину"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500005e"),
  "category": "app",
  "language": "uk",
  "message": "Langs",
  "translation": "Мови"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5227261873bda4044b00012d"),
  "category": "app",
  "language": "en",
  "message": "Common ID",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5227261873bda4044b00015f"),
  "category": "app",
  "language": "en",
  "message": "Results",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000077"),
  "category": "app",
  "language": "uk",
  "message": "Newer",
  "translation": "Далі"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500002c"),
  "category": "app",
  "language": "uk",
  "message": "Email",
  "translation": "Email"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000059"),
  "category": "app",
  "language": "uk",
  "message": "Ukranian Collegiate Programming Contest",
  "translation": "Всеукраїнська студентська олімпіада з програмування"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000043"),
  "category": "app",
  "language": "uk",
  "message": "Lang",
  "translation": "Мова"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c2500001e"),
  "category": "app",
  "language": "uk",
  "message": "Type",
  "translation": "Тип"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000015"),
  "category": "app",
  "language": "uk",
  "message": "Unable to change the item name. The name \"{name}\" is already used by another item.",
  "translation": "Неможливо змінити ім'я елементу. Ім'я \"{name}\" вже використовується іншим елементом."
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000009"),
  "category": "app",
  "language": "uk",
  "message": "Name",
  "translation": "Ім'я"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000093"),
  "category": "app",
  "language": "ru",
  "message": "View Facebook profile basic information.",
  "translation": "Смотреть базовую информацию по Facebook профилю"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000c3"),
  "category": "app",
  "language": "ru",
  "message": "Update translation messages",
  "translation": "Обновить переводы"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000ed"),
  "category": "app",
  "language": "ru",
  "message": "Upload Doc",
  "translation": "Загрузить документ"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5227261873bda4044b0000f7"),
  "category": "app",
  "language": "ru",
  "message": "Requested news has no translation in {lang}",
  "translation": "Новость не имеет перевода на {lang}"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5253c844445798cd448b46d4"),
  "category": "app",
  "language": "en",
  "message": "Preview",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b472c"),
  "category": "app",
  "language": "en",
  "message": "Action",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5227261873bda4044b000074"),
  "category": "app",
  "language": "uk",
  "message": "Requested news has no translation in {lang}",
  "translation": "Не має перекладу для новини на {lang}"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5242969d445798cc118b45a3"),
  "category": "app",
  "language": "uk",
  "message": "Please, read and accept service rules",
  "translation": "Будь ласка, прочитайте та прийміть умови сервісу"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5242969d445798cc118b4665"),
  "category": "app",
  "language": "ru",
  "message": "I agree with rules of the service",
  "translation": "Я согласен с правилами сервиса"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5242969d445798cc118b4630"),
  "category": "app",
  "language": "ru",
  "message": "Please, read and accept service rules",
  "translation": "Пожалуйста, прочитайте и примите правила сервиса"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b472e"),
  "category": "app",
  "language": "en",
  "message": "Suspend",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b4754"),
  "category": "app",
  "language": "en",
  "message": "I'm a coach",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b4756"),
  "category": "app",
  "language": "en",
  "message": "Ukraine",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b4757"),
  "category": "app",
  "language": "en",
  "message": "Region",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b4758"),
  "category": "app",
  "language": "en",
  "message": "Center",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b4759"),
  "category": "app",
  "language": "en",
  "message": "East",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b475b"),
  "category": "app",
  "language": "en",
  "message": "South",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b475c"),
  "category": "app",
  "language": "en",
  "message": "West",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b475e"),
  "category": "app",
  "language": "en",
  "message": "ARC",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b475f"),
  "category": "app",
  "language": "en",
  "message": "Cherkasy",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b4760"),
  "category": "app",
  "language": "en",
  "message": "Chernihiv",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b4761"),
  "category": "app",
  "language": "en",
  "message": "Chernivtsi",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b4762"),
  "category": "app",
  "language": "en",
  "message": "Dnipropetrovsk",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b4763"),
  "category": "app",
  "language": "en",
  "message": "Donetsk",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b4764"),
  "category": "app",
  "language": "en",
  "message": "Ivano-Frankivsk",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b4765"),
  "category": "app",
  "language": "en",
  "message": "Kharkiv",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b4766"),
  "category": "app",
  "language": "en",
  "message": "Kherson",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b4767"),
  "category": "app",
  "language": "en",
  "message": "Khmelnytskyi",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b4768"),
  "category": "app",
  "language": "en",
  "message": "Kiev",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b4769"),
  "category": "app",
  "language": "en",
  "message": "Kirovohrad",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b476a"),
  "category": "app",
  "language": "en",
  "message": "Luhansk",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b476b"),
  "category": "app",
  "language": "en",
  "message": "Lviv",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b476c"),
  "category": "app",
  "language": "en",
  "message": "Mykolaiv",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b476d"),
  "category": "app",
  "language": "en",
  "message": "Odessa",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b476e"),
  "category": "app",
  "language": "en",
  "message": "Poltava",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b476f"),
  "category": "app",
  "language": "en",
  "message": "Rivne",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b4770"),
  "category": "app",
  "language": "en",
  "message": "Sumy",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b4771"),
  "category": "app",
  "language": "en",
  "message": "Ternopil",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b4772"),
  "category": "app",
  "language": "en",
  "message": "Vinnytsia",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b4773"),
  "category": "app",
  "language": "en",
  "message": "Volyn",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b4774"),
  "category": "app",
  "language": "en",
  "message": "Zakarpattia",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b4775"),
  "category": "app",
  "language": "en",
  "message": "Zaporizhia",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b4776"),
  "category": "app",
  "language": "en",
  "message": "Zhytomyr",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b45fc"),
  "category": "app",
  "language": "uk",
  "message": "Sumy",
  "translation": "Суми"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b45fb"),
  "category": "app",
  "language": "uk",
  "message": "Rivne",
  "translation": "Рівне"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b45f7"),
  "category": "app",
  "language": "uk",
  "message": "Lviv",
  "translation": "Львів"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b45f4"),
  "category": "app",
  "language": "uk",
  "message": "Kiev",
  "translation": "Київ"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b45ea"),
  "category": "app",
  "language": "uk",
  "message": "ARC",
  "translation": "АРК"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b45e8"),
  "category": "app",
  "language": "uk",
  "message": "West",
  "translation": "Захід"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5253c844445798cd448b45f4"),
  "category": "appjs",
  "language": "uk",
  "message": "You have unsaved changes.",
  "translation": "У вас є незбережені зміни."
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000039"),
  "category": "app",
  "language": "uk",
  "message": "Failed to open output stream.",
  "translation": "Невдалося відкрити вихідний потік."
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000038"),
  "category": "app",
  "language": "uk",
  "message": "Failed to open input stream.",
  "translation": "Невдалося відкрити вхідний потік."
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000037"),
  "category": "app",
  "language": "uk",
  "message": "Failed to move uploaded file.",
  "translation": "Невдалося перемістити завантажений файл."
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000030"),
  "category": "app",
  "language": "uk",
  "message": "{attr} length should be less or equal than {val}.",
  "translation": "Довжина {attr} має бути не більше ніж {val}."
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000032"),
  "category": "app",
  "language": "uk",
  "message": "{attr} length should be greater or equal than {val}.",
  "translation": "Довжина {attr} має бути не менше ніж {val}."
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b46b5"),
  "category": "app",
  "language": "ru",
  "message": "Rivne",
  "translation": "Ровное"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b46b3"),
  "category": "app",
  "language": "ru",
  "message": "Odessa",
  "translation": "Одесса"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b46b2"),
  "category": "app",
  "language": "ru",
  "message": "Mykolaiv",
  "translation": "Николаев"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b46b0"),
  "category": "app",
  "language": "ru",
  "message": "Luhansk",
  "translation": "Луганск"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b46af"),
  "category": "app",
  "language": "ru",
  "message": "Kirovohrad",
  "translation": "Кировоград"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b46ad"),
  "category": "app",
  "language": "ru",
  "message": "Khmelnytskyi",
  "translation": "Хмельницкий"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b46ac"),
  "category": "app",
  "language": "ru",
  "message": "Kherson",
  "translation": "Херсон"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b46ab"),
  "category": "app",
  "language": "ru",
  "message": "Kharkiv",
  "translation": "Харьков"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b46aa"),
  "category": "app",
  "language": "ru",
  "message": "Ivano-Frankivsk",
  "translation": "Ивано-Франковск"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b46a9"),
  "category": "app",
  "language": "ru",
  "message": "Donetsk",
  "translation": "Донецк"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b46a8"),
  "category": "app",
  "language": "ru",
  "message": "Dnipropetrovsk",
  "translation": "Днепропетровск"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b46a7"),
  "category": "app",
  "language": "ru",
  "message": "Chernivtsi",
  "translation": "Черновцы"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b46a6"),
  "category": "app",
  "language": "ru",
  "message": "Chernihiv",
  "translation": "Чернигов"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b46a5"),
  "category": "app",
  "language": "ru",
  "message": "Cherkasy",
  "translation": "Черкассы"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b46a3"),
  "category": "app",
  "language": "ru",
  "message": "State",
  "translation": "Область"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b469f"),
  "category": "app",
  "language": "ru",
  "message": "East",
  "translation": "Восток"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b469e"),
  "category": "app",
  "language": "ru",
  "message": "Center",
  "translation": "Центр"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b469d"),
  "category": "app",
  "language": "ru",
  "message": "Region",
  "translation": "Регион"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b469c"),
  "category": "app",
  "language": "ru",
  "message": "Ukraine",
  "translation": "Украина"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b469b"),
  "category": "app",
  "language": "ru",
  "message": "Coordinator",
  "translation": "Координатор"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b469a"),
  "category": "app",
  "language": "ru",
  "message": "I'm a coach",
  "translation": "Тренер"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b4674"),
  "category": "app",
  "language": "ru",
  "message": "Suspend",
  "translation": "Приостановить"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52551c0f445798444b8b4673"),
  "category": "app",
  "language": "ru",
  "message": "Activate",
  "translation": "Активировать"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5253c844445798cd448b4681"),
  "category": "appjs",
  "language": "ru",
  "message": "You have unsaved changes.",
  "translation": "У вас есть несохранённые данные."
});
db.getCollection("translation").insert({
  "_id": ObjectId("5253c844445798cd448b4647"),
  "category": "app",
  "language": "ru",
  "message": "Preview",
  "translation": "Предпросмотр"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5242969d445798cc118b462d"),
  "category": "app",
  "language": "ru",
  "message": "Related user ID",
  "translation": "ИН связанного пользователя"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5253c844445798cd448b4648"),
  "category": "app",
  "language": "ru",
  "message": "Upload images here",
  "translation": "Загрузить картинки здесь"
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000b5"),
  "category": "app",
  "language": "ru",
  "message": "Failed to open output stream.",
  "translation": "Неудалось открыть исходящий поток."
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000b4"),
  "category": "app",
  "language": "ru",
  "message": "Failed to open input stream.",
  "translation": "Неудалось открыть входящий поток."
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000b3"),
  "category": "app",
  "language": "ru",
  "message": "Failed to move uploaded file.",
  "translation": "Неудалось переместить загруженный файл."
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000af"),
  "category": "app",
  "language": "ru",
  "message": "{controller} has an extra endWidget({id}) call in its view.",
  "translation": "{controller} содержит лишний вызов endWidget({id}) в файле представления."
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000ae"),
  "category": "app",
  "language": "ru",
  "message": "{attr} length should be greater or equal than {val}.",
  "translation": "Длинна {attr} должна быть не меньше {val}."
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000ad"),
  "category": "app",
  "language": "ru",
  "message": "{attr} is not confirmed.",
  "translation": "{attr} не подтверждён."
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c250000ac"),
  "category": "app",
  "language": "ru",
  "message": "{attr} length should be less or equal than {val}.",
  "translation": "Длинна {attr} должна быть не больше {val}."
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000095"),
  "category": "app",
  "language": "ru",
  "message": "The EMongoDocument cannot be deleted because it is new.",
  "translation": "Невозможно удалить EMongoDocument так как он новый."
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000097"),
  "category": "app",
  "language": "ru",
  "message": "{attribute} is not unique in DB.",
  "translation": "{attribute} не уникален в БД."
});
db.getCollection("translation").insert({
  "_id": ObjectId("525557f14457985e508b473e"),
  "category": "app",
  "language": "en",
  "message": "Do it with us, do it like us, do it better than us!",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("525557f14457985e508b4683"),
  "category": "app",
  "language": "ru",
  "message": "Do it with us, do it like us, do it better than us!",
  "translation": "Делай с нами, делай как мы, делай лучше нас!"
});
db.getCollection("translation").insert({
  "_id": ObjectId("525557f14457985e508b45c8"),
  "category": "app",
  "language": "uk",
  "message": "Do it with us, do it like us, do it better than us!",
  "translation": "Роби із нами, роби як ми, роби краще за нас!"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5256cb1344579885588b475c"),
  "category": "app",
  "language": "en",
  "message": "Coordination type",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5256cb1344579885588b478d"),
  "category": "app",
  "language": "en",
  "message": "Can not set state for oneself.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5256cb1344579885588b459e"),
  "category": "app",
  "language": "uk",
  "message": "Coordination type",
  "translation": "Тип коодинатору"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5256cb1344579885588b45cf"),
  "category": "app",
  "language": "uk",
  "message": "Can not set state for oneself.",
  "translation": "Неможна міняти статус собі самому."
});
db.getCollection("translation").insert({
  "_id": ObjectId("5256cb1344579885588b46c3"),
  "category": "app",
  "language": "ru",
  "message": "Create News",
  "translation": "Добавить новость"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5256cb1344579885588b46ae"),
  "category": "app",
  "language": "ru",
  "message": "Can not set state for oneself.",
  "translation": "Нельзя менять статус себе самому."
});
db.getCollection("translation").insert({
  "_id": ObjectId("52248a3673bda44c25000089"),
  "category": "app",
  "language": "ru",
  "message": "List of children",
  "translation": "Список дочерних элементов"
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b4799"),
  "category": "app",
  "language": "en",
  "message": "Desc",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b47c3"),
  "category": "app",
  "language": "en",
  "message": "User should have some role.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b47ca"),
  "category": "app",
  "language": "en",
  "message": "Official post and email addresses",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b47cf"),
  "category": "app",
  "language": "en",
  "message": "Home phone number",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b47d0"),
  "category": "app",
  "language": "en",
  "message": "Mobile phone number",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b47d1"),
  "category": "app",
  "language": "en",
  "message": "Skype",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b47d2"),
  "category": "app",
  "language": "en",
  "message": "ACM number if you have",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b47d5"),
  "category": "app",
  "language": "en",
  "message": "Work phone number",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b47d8"),
  "category": "app",
  "language": "en",
  "message": "Speciality of study",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b47d9"),
  "category": "app",
  "language": "en",
  "message": "Faculty of study",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b47da"),
  "category": "app",
  "language": "en",
  "message": "Group",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b47db"),
  "category": "app",
  "language": "en",
  "message": "Year of admission to University",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b47dd"),
  "category": "app",
  "language": "en",
  "message": "Document serial number",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b47df"),
  "category": "app",
  "language": "en",
  "message": "Date",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b47e2"),
  "category": "app",
  "language": "en",
  "message": "We do not know such a email.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b4816"),
  "category": "app",
  "language": "en",
  "message": "Your can change your password by the following link",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b481a"),
  "category": "app",
  "language": "en",
  "message": "Forgot your password?",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b4820"),
  "category": "app",
  "language": "en",
  "message": "Password reset sent",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b4821"),
  "category": "app",
  "language": "en",
  "message": "Email with password reset link was successfuly sent.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b4822"),
  "category": "app",
  "language": "en",
  "message": "Please check your email.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b4823"),
  "category": "app",
  "language": "en",
  "message": "Return back to the main page",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b4824"),
  "category": "app",
  "language": "en",
  "message": "Set a new password",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5260e6a9445798b6048b4829"),
  "category": "app",
  "language": "en",
  "message": "Your token is invalid or expired.",
  "translation": ""
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Your token is invalid or expired.",
  "translation": "Ваш код невалиден или истёк.",
  "_id": ObjectId("5260e6a9445798b6048b472e")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Set a new password",
  "translation": "Установить новый пароль",
  "_id": ObjectId("5260e6a9445798b6048b4729")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Return back to the main page",
  "translation": "Вернуться на главную страницу",
  "_id": ObjectId("5260e6a9445798b6048b4728")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Please check your email.",
  "translation": "Пожалуйста, проверьте вашу почту.",
  "_id": ObjectId("5260e6a9445798b6048b4727")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Email with password reset link was successfuly sent.",
  "translation": "Письмо со ссылкой на сброс пароля было успешно отправлено.",
  "_id": ObjectId("5260e6a9445798b6048b4726")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Password reset sent",
  "translation": "Сброс пароля отправлен",
  "_id": ObjectId("5260e6a9445798b6048b4725")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Forgot your password?",
  "translation": "Забыли пароль?",
  "_id": ObjectId("5260e6a9445798b6048b471f")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Your can change your password by the following link",
  "translation": "Выможете изменить ваш пароль по ссылке",
  "_id": ObjectId("5260e6a9445798b6048b471b")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "We do not know such a email.",
  "translation": "Мы не знаем такого адреса.",
  "_id": ObjectId("5260e6a9445798b6048b46e7")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Document serial number",
  "translation": "Серийный номер документа",
  "_id": ObjectId("5260e6a9445798b6048b46e2")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Group",
  "translation": "Группа",
  "_id": ObjectId("5260e6a9445798b6048b46df")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Desc",
  "translation": "Описание",
  "_id": ObjectId("5260e6a9445798b6048b469e")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "User should have some role.",
  "translation": "Пользователь должен иметь роль.",
  "_id": ObjectId("5260e6a9445798b6048b46c8")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Question ID",
  "translation": "ИН вопроса",
  "_id": ObjectId("5260e6a9445798b6048b4694")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Assigned tags",
  "translation": "Подвязанные теги",
  "_id": ObjectId("5260e6a9445798b6048b469a")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Your token is invalid or expired.",
  "translation": "Ваш код невалідний або застарів.",
  "_id": ObjectId("5260e6a9445798b6048b4633")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Set a new password",
  "translation": "Встановити новий пароль",
  "_id": ObjectId("5260e6a9445798b6048b462e")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Return back to the main page",
  "translation": "Повернутися на головну сторінку",
  "_id": ObjectId("5260e6a9445798b6048b462d")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Please check your email.",
  "translation": "Будь ласка, перевірте вашу пошту.",
  "_id": ObjectId("5260e6a9445798b6048b462c")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Email with password reset link was successfuly sent.",
  "translation": "Лист із посиланням на скидання пароля успішно відправлено.",
  "_id": ObjectId("5260e6a9445798b6048b462b")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Password reset sent",
  "translation": "Скидання паролю відправлено",
  "_id": ObjectId("5260e6a9445798b6048b462a")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Forgot your password?",
  "translation": "Забули пароль?",
  "_id": ObjectId("5260e6a9445798b6048b4624")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Your can change your password by the following link",
  "translation": "Ви можете змінити пароль за цим посиланням",
  "_id": ObjectId("5260e6a9445798b6048b4620")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "We do not know such a email.",
  "translation": "Ми не знаємо такої адреси.",
  "_id": ObjectId("5260e6a9445798b6048b45ec")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Date",
  "translation": "Дата",
  "_id": ObjectId("5260e6a9445798b6048b45e9")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Type of auth item",
  "translation": "Тип авторизаційного елементу",
  "_id": ObjectId("52248a3673bda44c25000008")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "List of children",
  "translation": "Список дочірніх елементів",
  "_id": ObjectId("52248a3673bda44c2500000d")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Children can not containt item name.",
  "translation": "Дочірні елементи не можуть містити ім'я елементу.",
  "_id": ObjectId("52248a3673bda44c2500000e")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Assigned tags",
  "translation": "Долучені теги",
  "_id": ObjectId("5260e6a9445798b6048b459f")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Answer count",
  "translation": "Кількість відповідей",
  "_id": ObjectId("5260e6a9445798b6048b45a0")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Resend token",
  "translation": "Відправити код ще раз",
  "_id": ObjectId("5260e6a9445798b6048b4634")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Reset password",
  "translation": "Скинути пароль",
  "_id": ObjectId("5260e6a9445798b6048b4629")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Password reset",
  "translation": "Скидання паролю",
  "_id": ObjectId("5260e6a9445798b6048b45ed")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Date of birth",
  "translation": "Дата народження",
  "_id": ObjectId("5260e6a9445798b6048b45e6")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Fax number",
  "translation": "Факс",
  "_id": ObjectId("5260e6a9445798b6048b45e0")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Office address",
  "translation": "Робоча адреса",
  "_id": ObjectId("5260e6a9445798b6048b45de")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Position",
  "translation": "Посада",
  "_id": ObjectId("5260e6a9445798b6048b45dd")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "User should have some role.",
  "translation": "Користувач мусить мати роль.",
  "_id": ObjectId("5260e6a9445798b6048b45cd")
});
db.getCollection("translation").insert({
  "_id": ObjectId("52677c8a445798ab308b4804"),
  "category": "app",
  "language": "en",
  "message": "List of Coaches",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52677c8a445798ab308b480b"),
  "category": "app",
  "language": "en",
  "message": "List of Coordinators",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52677c8a445798ab308b482d"),
  "category": "app",
  "language": "en",
  "message": "Coordinators",
  "translation": ""
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Coordinators",
  "translation": "Координаторы",
  "_id": ObjectId("52677c8a445798ab308b4727")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "List of Coordinators",
  "translation": "Список координаторов",
  "_id": ObjectId("52677c8a445798ab308b4705")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Password reset",
  "translation": "Сброс пароля",
  "_id": ObjectId("5260e6a9445798b6048b46e8")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Reset password",
  "translation": "Сбросить пароль",
  "_id": ObjectId("5260e6a9445798b6048b4724")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Resend token",
  "translation": "Отправить код ещё раз",
  "_id": ObjectId("5260e6a9445798b6048b472f")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "List of Coaches",
  "translation": "Список тренеров",
  "_id": ObjectId("52677c8a445798ab308b46fe")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Users",
  "translation": "Пользователи",
  "_id": ObjectId("52677c8a445798ab308b4726")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Coaches",
  "translation": "Тренеры",
  "_id": ObjectId("52677c8a445798ab308b4728")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Type of auth item",
  "translation": "Тип авторизационного элемента",
  "_id": ObjectId("52248a3673bda44c25000084")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Coordinators",
  "translation": "Координатори",
  "_id": ObjectId("52677c8a445798ab308b4621")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "List of Coordinators",
  "translation": "Список координаторів",
  "_id": ObjectId("52677c8a445798ab308b45ff")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "List of Coaches",
  "translation": "Список тренерів",
  "_id": ObjectId("52677c8a445798ab308b45f8")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "{attribute} is not unique in DB.",
  "translation": "{attribute} не є унікальним у БД.",
  "_id": ObjectId("52248a3673bda44c2500001b")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Users",
  "translation": "Користувачі",
  "_id": ObjectId("52677c8a445798ab308b4620")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Coaches",
  "translation": "Тренери",
  "_id": ObjectId("52677c8a445798ab308b4622")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Region name",
  "translation": "Регіон",
  "_id": ObjectId("52720676445798e6728b4591")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Year date",
  "translation": "Рік",
  "_id": ObjectId("52720676445798e6728b45b7")
});
db.getCollection("translation").insert({
  "_id": ObjectId("52720677445798e6728b47c5"),
  "category": "app",
  "language": "en",
  "message": "Unknown state name.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52720677445798e6728b47c6"),
  "category": "app",
  "language": "en",
  "message": "State name",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52720677445798e6728b47e5"),
  "category": "app",
  "language": "en",
  "message": "Year date",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52720677445798e6728b47e6"),
  "category": "app",
  "language": "en",
  "message": "Date date",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52720677445798e6728b47f4"),
  "category": "app",
  "language": "en",
  "message": "Full university name in ukrainian",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52720677445798e6728b47f5"),
  "category": "app",
  "language": "en",
  "message": "Full university name in english",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52720677445798e6728b47f6"),
  "category": "app",
  "language": "en",
  "message": "Short university name in ukrainian",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52720677445798e6728b47f7"),
  "category": "app",
  "language": "en",
  "message": "Short university name in english",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52720677445798e6728b4806"),
  "category": "app",
  "language": "en",
  "message": "Unknown coordinator type.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52720677445798e6728b4807"),
  "category": "app",
  "language": "en",
  "message": "Student can not be coordinator.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52720677445798e6728b488c"),
  "category": "app",
  "language": "en",
  "message": "{year} year",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("52720677445798e6728b4893"),
  "category": "app",
  "language": "en",
  "message": "News for the previous year: {year}",
  "translation": ""
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "News for the previous year: {year}",
  "translation": "Новости за предыдущий год: {year}",
  "_id": ObjectId("52720677445798e6728b477c")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Student can not be coordinator.",
  "translation": "Студент не может быть координатором.",
  "_id": ObjectId("52720677445798e6728b46f0")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Unknown coordinator type.",
  "translation": "Неизвестный тип координатора.",
  "_id": ObjectId("52720677445798e6728b46ef")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Geo",
  "translation": "Гео",
  "_id": ObjectId("5289cb7d44579889608b45b7")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Name of a team",
  "translation": "Назва команди",
  "_id": ObjectId("5289cb7d44579889608b45d0")
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b48af"),
  "category": "app",
  "language": "en",
  "message": "Geo",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b48c9"),
  "category": "app",
  "language": "en",
  "message": "Year in which team participated",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b48cb"),
  "category": "app",
  "language": "en",
  "message": "Related school ID",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b48cc"),
  "category": "app",
  "language": "en",
  "message": "List of members",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b48cd"),
  "category": "app",
  "language": "en",
  "message": "The number of members should be greater or equal then 3.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b48ce"),
  "category": "app",
  "language": "en",
  "message": "The number of members should be less or equal then 4.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b48d8"),
  "category": "app",
  "language": "en",
  "message": "Middle name in Ukranian",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b48d9"),
  "category": "app",
  "language": "en",
  "message": "Last name in Ukrainian",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b48da"),
  "category": "app",
  "language": "en",
  "message": "First name in English",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b48db"),
  "category": "app",
  "language": "en",
  "message": "Middle name in English",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b48dc"),
  "category": "app",
  "language": "en",
  "message": "Last name in English",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b48ea"),
  "category": "app",
  "language": "en",
  "message": "Language of the information",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b48f0"),
  "category": "app",
  "language": "en",
  "message": "Short name of the school name",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b4901"),
  "category": "app",
  "language": "en",
  "message": "Year",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b490e"),
  "category": "app",
  "language": "en",
  "message": "{attr} is incorrect",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b4917"),
  "category": "app",
  "language": "en",
  "message": "To manage teams, you must specify your school on the {a}profile page{\/a}.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b4923"),
  "category": "app",
  "language": "en",
  "message": "Coordinates",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b4939"),
  "category": "app",
  "language": "en",
  "message": "Team Info",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b493a"),
  "category": "app",
  "language": "en",
  "message": "year",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b493b"),
  "category": "app",
  "language": "en",
  "message": "Short name of university (ukrainian)",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b493c"),
  "category": "app",
  "language": "en",
  "message": "Full name of university (english)",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b493d"),
  "category": "app",
  "language": "en",
  "message": "Short name of university (english)",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b493f"),
  "category": "app",
  "language": "en",
  "message": "Name of your team",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b4940"),
  "category": "app",
  "language": "en",
  "message": "Full name preview",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b4941"),
  "category": "app",
  "language": "en",
  "message": "Name of your team with prefix",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b4942"),
  "category": "app",
  "language": "en",
  "message": "Members",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b4943"),
  "category": "app",
  "language": "en",
  "message": "Save",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b494e"),
  "category": "app",
  "language": "en",
  "message": "Teams",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b498a"),
  "category": "app",
  "language": "en",
  "message": "Create a new team",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b498b"),
  "category": "app",
  "language": "en",
  "message": "Team name",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b498c"),
  "category": "app",
  "language": "en",
  "message": "There are no teams.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b498d"),
  "category": "app",
  "language": "en",
  "message": "Manage",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b498e"),
  "category": "app",
  "language": "en",
  "message": "Coach",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b4990"),
  "category": "app",
  "language": "en",
  "message": "Participants",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b499a"),
  "category": "app",
  "language": "en",
  "message": "No additional information for you.",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b499d"),
  "category": "app",
  "language": "en",
  "message": "Speciality",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b499f"),
  "category": "app",
  "language": "en",
  "message": "Faculty",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b49a3"),
  "category": "app",
  "language": "en",
  "message": "Year of admission to school",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b49a7"),
  "category": "app",
  "language": "en",
  "message": "Student document serial number",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b49aa"),
  "category": "app",
  "language": "en",
  "message": "First name (ukranian)",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b49ab"),
  "category": "app",
  "language": "en",
  "message": "Middle name (ukranian)",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b49ac"),
  "category": "app",
  "language": "en",
  "message": "Last name (ukranian)",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b49ad"),
  "category": "app",
  "language": "en",
  "message": "First name (english)",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b49ae"),
  "category": "app",
  "language": "en",
  "message": "Middle name (english)",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b49af"),
  "category": "app",
  "language": "en",
  "message": "Last name (english)",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b49b2"),
  "category": "app",
  "language": "en",
  "message": "Roles",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b49b8"),
  "category": "app",
  "language": "en",
  "message": "Current password",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b49b9"),
  "category": "app",
  "language": "en",
  "message": "Set only if you want to change it",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b49ba"),
  "category": "app",
  "language": "en",
  "message": "New password",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b49bb"),
  "category": "app",
  "language": "en",
  "message": "Repeat new password",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b49bd"),
  "category": "app",
  "language": "en",
  "message": "Home phone",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b49bf"),
  "category": "app",
  "language": "en",
  "message": "Mobile phone",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b49c3"),
  "category": "app",
  "language": "en",
  "message": "ACM Number",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b49c7"),
  "category": "app",
  "language": "en",
  "message": "School short name",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b49c9"),
  "category": "app",
  "language": "en",
  "message": "Divison (I or II)",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b49cc"),
  "category": "app",
  "language": "en",
  "message": "General info",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b49cd"),
  "category": "app",
  "language": "en",
  "message": "Additional info (ukrainian)",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b49ce"),
  "category": "app",
  "language": "en",
  "message": "Additional info (english)",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b49d1"),
  "category": "app",
  "language": "en",
  "message": "Delete {file} ?",
  "translation": ""
});
db.getCollection("translation").insert({
  "_id": ObjectId("5289cb7d44579889608b49d2"),
  "category": "app",
  "language": "en",
  "message": "Delete",
  "translation": ""
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Delete",
  "translation": "Удалить",
  "_id": ObjectId("5289cb7d44579889608b4856")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Delete {file} ?",
  "translation": "Удалить {file} ?",
  "_id": ObjectId("5289cb7d44579889608b4855")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Additional info (english)",
  "translation": "Доп. информация (на английском)",
  "_id": ObjectId("5289cb7d44579889608b4852")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Additional info (ukrainian)",
  "translation": "Доп информация (на украинском)",
  "_id": ObjectId("5289cb7d44579889608b4851")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "General info",
  "translation": "Основные данные",
  "_id": ObjectId("5289cb7d44579889608b4850")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Divison (I or II)",
  "translation": "Подразделение (I или II)",
  "_id": ObjectId("5289cb7d44579889608b484d")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "School short name",
  "translation": "Короткое имя ВУЗа",
  "_id": ObjectId("5289cb7d44579889608b484b")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "ACM Number",
  "translation": "Номер ACM",
  "_id": ObjectId("5289cb7d44579889608b4847")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Home phone",
  "translation": "Домашний телефон",
  "_id": ObjectId("5289cb7d44579889608b4841")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Mobile phone",
  "translation": "Мобильный телефон",
  "_id": ObjectId("5289cb7d44579889608b4843")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Repeat new password",
  "translation": "Новый пароль ещё раз",
  "_id": ObjectId("5289cb7d44579889608b483f")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "New password",
  "translation": "Новый пароль",
  "_id": ObjectId("5289cb7d44579889608b483e")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Set only if you want to change it",
  "translation": "Вводите, если только хотите изменить его",
  "_id": ObjectId("5289cb7d44579889608b483d")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Current password",
  "translation": "Текущий пароль",
  "_id": ObjectId("5289cb7d44579889608b483c")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Last name (english)",
  "translation": "Фамилия (на английском)",
  "_id": ObjectId("5289cb7d44579889608b4833")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Middle name (english)",
  "translation": "Отчество (на английском)",
  "_id": ObjectId("5289cb7d44579889608b4832")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "First name (english)",
  "translation": "Имя (на английском)",
  "_id": ObjectId("5289cb7d44579889608b4831")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Last name (ukranian)",
  "translation": "Фамилия (на украинском)",
  "_id": ObjectId("5289cb7d44579889608b4830")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Middle name (ukranian)",
  "translation": "Отчество (на украинском)",
  "_id": ObjectId("5289cb7d44579889608b482f")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "First name (ukranian)",
  "translation": "Имя (на украинском)",
  "_id": ObjectId("5289cb7d44579889608b482e")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Student document serial number",
  "translation": "Серийный номер студенческого",
  "_id": ObjectId("5289cb7d44579889608b482b")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Year of admission to school",
  "translation": "Год поступления",
  "_id": ObjectId("5289cb7d44579889608b4827")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "No additional information for you.",
  "translation": "Допольнительная информация не доступна для Вас.",
  "_id": ObjectId("5289cb7d44579889608b481e")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Participants",
  "translation": "Участники",
  "_id": ObjectId("5289cb7d44579889608b4814")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "There are no teams.",
  "translation": "Комманд пока нет.",
  "_id": ObjectId("5289cb7d44579889608b4810")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Create a new team",
  "translation": "Создать новую комманду",
  "_id": ObjectId("5289cb7d44579889608b480e")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Name of your team with prefix",
  "translation": "Имя команды с префиксом",
  "_id": ObjectId("5289cb7d44579889608b47c5")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Full name preview",
  "translation": "Предпросмотр полного имени",
  "_id": ObjectId("5289cb7d44579889608b47c4")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Name of your team",
  "translation": "Имя комманды",
  "_id": ObjectId("5289cb7d44579889608b47c3")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Short name of university (english)",
  "translation": "Короткое имя ВУЗа (на английском)",
  "_id": ObjectId("5289cb7d44579889608b47c1")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Full name of university (english)",
  "translation": "Полное имя ВУЗа (на английском)",
  "_id": ObjectId("5289cb7d44579889608b47c0")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Short name of university (ukrainian)",
  "translation": "Короткое имя ВУЗа (на украинском)",
  "_id": ObjectId("5289cb7d44579889608b47bf")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Coordinates",
  "translation": "Координаторы",
  "_id": ObjectId("5289cb7d44579889608b47a7")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "To manage teams, you must specify your school on the {a}profile page{\/a}.",
  "translation": "Для управления коммандами, Вы должны указать свой ВУЗ на {a}странице профиля{\/a}.",
  "_id": ObjectId("5289cb7d44579889608b479b")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "{attr} is incorrect",
  "translation": "{attr} не корректен",
  "_id": ObjectId("5289cb7d44579889608b4792")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Short name of the school name",
  "translation": "Короткое названаие ВУЗа",
  "_id": ObjectId("5289cb7d44579889608b4774")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "School name",
  "translation": "Название ВУЗа",
  "_id": ObjectId("5289cb7d44579889608b4773")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Language of the information",
  "translation": "Язык информации",
  "_id": ObjectId("5289cb7d44579889608b476e")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Last name in English",
  "translation": "Фамилия на английском",
  "_id": ObjectId("5289cb7d44579889608b4760")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Middle name in English",
  "translation": "Отчество на английском",
  "_id": ObjectId("5289cb7d44579889608b475f")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "First name in English",
  "translation": "Имя на английском",
  "_id": ObjectId("5289cb7d44579889608b475e")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Last name in Ukrainian",
  "translation": "Фамилия на украинсокм",
  "_id": ObjectId("5289cb7d44579889608b475d")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Middle name in Ukranian",
  "translation": "Отчество на украинском",
  "_id": ObjectId("5289cb7d44579889608b475c")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "{attr} cannot be empty",
  "translation": "{attr} не может быть пустым",
  "_id": ObjectId("5289cb7d44579889608b4753")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "The number of members should be less or equal then 4.",
  "translation": "Количество участников не должно превышать 4.",
  "_id": ObjectId("5289cb7d44579889608b4752")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "The number of members should be greater or equal then 3.",
  "translation": "Количество участников на должно быть меньше 3.",
  "_id": ObjectId("5289cb7d44579889608b4751")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "List of members",
  "translation": "Список участников",
  "_id": ObjectId("5289cb7d44579889608b4750")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Related school ID",
  "translation": "ИН связанного ВУЗа",
  "_id": ObjectId("5289cb7d44579889608b474f")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Related coach ID",
  "translation": "ИН связанного тренера",
  "_id": ObjectId("5289cb7d44579889608b474e")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Year in which team participated",
  "translation": "Год участия комманды",
  "_id": ObjectId("5289cb7d44579889608b474d")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Short university name in english",
  "translation": "Короткое название ВУЗа на английском",
  "_id": ObjectId("52720677445798e6728b46e0")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Short university name in ukrainian",
  "translation": "Короткое название ВУЗа на украинском",
  "_id": ObjectId("52720677445798e6728b46df")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Full university name in english",
  "translation": "Полное название ВУЗа на английском",
  "_id": ObjectId("52720677445798e6728b46de")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Full university name in ukrainian",
  "translation": "Полное название ВУЗа на украинском",
  "_id": ObjectId("52720677445798e6728b46dd")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Unknown state name.",
  "translation": "Неизвестное имя области.",
  "_id": ObjectId("52720677445798e6728b46ae")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Year of admission to University",
  "translation": "Год поступления в ВУЗ",
  "_id": ObjectId("5260e6a9445798b6048b46e0")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Faculty of study",
  "translation": "Факультет",
  "_id": ObjectId("5260e6a9445798b6048b46de")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Speciality of study",
  "translation": "Специальность",
  "_id": ObjectId("5260e6a9445798b6048b46dd")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Work phone number",
  "translation": "Рабочий телефон",
  "_id": ObjectId("5260e6a9445798b6048b46da")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "ACM number if you have",
  "translation": "Номер ACM",
  "_id": ObjectId("5260e6a9445798b6048b46d7")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Skype",
  "translation": "Skype",
  "_id": ObjectId("5260e6a9445798b6048b46d6")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Mobile phone number",
  "translation": "Мобильный телефон",
  "_id": ObjectId("5260e6a9445798b6048b46d5")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Home phone number",
  "translation": "Домашний телефон",
  "_id": ObjectId("5260e6a9445798b6048b46d4")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Official post and email addresses",
  "translation": "Официальный почтовый адрес",
  "_id": ObjectId("5260e6a9445798b6048b46cf")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Unable to add an item whose name is the same as an existing item.",
  "translation": "Невозможно создать элемент с дублирующимся именем.",
  "_id": ObjectId("52248a3673bda44c25000090")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Authorization item \"{item}\" has already been assigned to user \"{user}\".",
  "translation": "Авторизационный элемент \"{item}\" уже подвязан к пользователю \"{user}\".",
  "_id": ObjectId("52248a3673bda44c2500008f")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Unknown authorization item \"{name}\".",
  "translation": "Неизвестный авторизационный элемент \"{name}\".",
  "_id": ObjectId("52248a3673bda44c2500008e")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "The item \"{parent}\" already has a child \"{child}\".",
  "translation": "Элемент \"{parent}\" уже имеет наследника \"{child}\".",
  "_id": ObjectId("52248a3673bda44c2500008d")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Cannot add \"{child}\" as a child of \"{parent}\". A loop has been detected.",
  "translation": "Невозможно добавить \"{child}\" как наследника \"{parent}\". Бесконечное зацикливание.",
  "_id": ObjectId("52248a3673bda44c2500008c")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Either \"{name}\" or \"{child}\" does not exist.",
  "translation": "Ни \"{name}\", ни \"{child}\" не существуют.",
  "_id": ObjectId("52248a3673bda44c2500008b")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Children can not containt item name.",
  "translation": "Наследники не могут содержать имя элемента.",
  "_id": ObjectId("52248a3673bda44c2500008a")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Faculty",
  "translation": "Факультет",
  "_id": ObjectId("5289cb7d44579889608b4823")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Speciality",
  "translation": "Специальность",
  "_id": ObjectId("5289cb7d44579889608b4821")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Coach",
  "translation": "Тренер",
  "_id": ObjectId("5289cb7d44579889608b4812")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Manage",
  "translation": "Управление",
  "_id": ObjectId("5289cb7d44579889608b4811")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Team name",
  "translation": "Имя комманды",
  "_id": ObjectId("5289cb7d44579889608b480f")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Teams",
  "translation": "Комманды",
  "_id": ObjectId("5289cb7d44579889608b47d2")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Save",
  "translation": "Сохранить",
  "_id": ObjectId("5289cb7d44579889608b47c7")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Members",
  "translation": "Участники",
  "_id": ObjectId("5289cb7d44579889608b47c6")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Team Info",
  "translation": "Информация о комманде",
  "_id": ObjectId("5289cb7d44579889608b47bd")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Division",
  "translation": "Подразделение",
  "_id": ObjectId("5289cb7d44579889608b4775")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Name of a team",
  "translation": "Имя комманды",
  "_id": ObjectId("5289cb7d44579889608b474c")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "{year} year",
  "translation": "{year} год",
  "_id": ObjectId("52720677445798e6728b4775")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "State name",
  "translation": "Область",
  "_id": ObjectId("52720677445798e6728b46af")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Unknown region name.",
  "translation": "Неизвестный регион.",
  "_id": ObjectId("52720677445798e6728b46a7")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Field of study",
  "translation": "Специальность",
  "_id": ObjectId("5260e6a9445798b6048b46dc")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Office address",
  "translation": "Рабочий адрес",
  "_id": ObjectId("5260e6a9445798b6048b46d9")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Position",
  "translation": "Должность",
  "_id": ObjectId("5260e6a9445798b6048b46d8")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Use setView() method instead of this one.",
  "translation": "Используйте метод setView() вместо этого.",
  "_id": ObjectId("5260e6a9445798b6048b4663")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "ru",
  "message": "Unable to change the item name. The name \"{name}\" is already used by another item.",
  "translation": "Невозможно изменить имя элемента. Имя \"{name}\" уже используется другим элементом.",
  "_id": ObjectId("52248a3673bda44c25000091")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Unknown coordinator type.",
  "translation": "Невідомий тип координатору.",
  "_id": ObjectId("52720676445798e6728b45d8")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Members",
  "translation": "Учасники",
  "_id": ObjectId("5289cb7d44579889608b464a")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Teams",
  "translation": "Команди",
  "_id": ObjectId("5289cb7d44579889608b4656")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Manage",
  "translation": "Керувати",
  "_id": ObjectId("5289cb7d44579889608b4695")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Coach",
  "translation": "Тренер",
  "_id": ObjectId("5289cb7d44579889608b4696")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Faculty",
  "translation": "Факультет",
  "_id": ObjectId("5289cb7d44579889608b46a7")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Delete",
  "translation": "Видалити",
  "_id": ObjectId("5289cb7d44579889608b46da")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Either \"{name}\" or \"{child}\" does not exist.",
  "translation": "Ані \"{name}\", ані \"{child}\" не існують.",
  "_id": ObjectId("52248a3673bda44c2500000f")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Cannot add \"{child}\" as a child of \"{parent}\". A loop has been detected.",
  "translation": "Неможливо додати \"{child}\" як нащадка \"{parent}\". Нескінчене зациклювання.",
  "_id": ObjectId("52248a3673bda44c25000010")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "The item \"{parent}\" already has a child \"{child}\".",
  "translation": "Елемент \"{parent}\" вже має нащадка \"{child}\".",
  "_id": ObjectId("52248a3673bda44c25000011")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Unknown authorization item \"{name}\".",
  "translation": "Невідомий авторизаційний елемент \"{name}\".",
  "_id": ObjectId("52248a3673bda44c25000012")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Authorization item \"{item}\" has already been assigned to user \"{user}\".",
  "translation": "Авторизаційний елемент \"{item}\" вже долучено до користувача \"{user}\".",
  "_id": ObjectId("52248a3673bda44c25000013")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Unable to add an item whose name is the same as an existing item.",
  "translation": "Неможливо додати елемент чиє ім'я не є унікальним.",
  "_id": ObjectId("52248a3673bda44c25000014")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "View Facebook profile basic information.",
  "translation": "Подивитися базову інформацію профіля Facebook.",
  "_id": ObjectId("52248a3673bda44c25000017")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "The EMongoDocument cannot be deleted because it is new.",
  "translation": "EMongoDocument не може бути видалений, бо він новий.",
  "_id": ObjectId("52248a3673bda44c25000019")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "{controller} has an extra endWidget({id}) call in its view.",
  "translation": "{controller} має зайвий виклик endWidget({id}) у його view-файлі.",
  "_id": ObjectId("52248a3673bda44c25000033")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Use setView() method instead of this one.",
  "translation": "Використовуйте метод setView() замість цього.",
  "_id": ObjectId("5260e6a9445798b6048b4568")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Official post and email addresses",
  "translation": "Офіційна поштова адреса",
  "_id": ObjectId("5260e6a9445798b6048b45d4")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Home phone number",
  "translation": "Домашній телефон",
  "_id": ObjectId("5260e6a9445798b6048b45d9")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Mobile phone number",
  "translation": "Мобільній телефон",
  "_id": ObjectId("5260e6a9445798b6048b45da")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Skype",
  "translation": "Skype",
  "_id": ObjectId("5260e6a9445798b6048b45db")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "ACM number if you have",
  "translation": "Номер ACM",
  "_id": ObjectId("5260e6a9445798b6048b45dc")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Work phone number",
  "translation": "Робочий телефон",
  "_id": ObjectId("5260e6a9445798b6048b45df")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Speciality of study",
  "translation": "Спеціальність",
  "_id": ObjectId("5260e6a9445798b6048b45e2")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Faculty of study",
  "translation": "Факультет",
  "_id": ObjectId("5260e6a9445798b6048b45e3")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Year of admission to University",
  "translation": "Рік вступу до ВНЗ",
  "_id": ObjectId("5260e6a9445798b6048b45e5")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Document serial number",
  "translation": "Серійний номер документу",
  "_id": ObjectId("5260e6a9445798b6048b45e7")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Unknown region name.",
  "translation": "Невідомий регіон.",
  "_id": ObjectId("52720676445798e6728b4590")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Unknown state name.",
  "translation": "Невідома область.",
  "_id": ObjectId("52720676445798e6728b4597")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "State name",
  "translation": "Область",
  "_id": ObjectId("52720676445798e6728b4598")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Full university name in ukrainian",
  "translation": "Повна назва ВНЗ українською",
  "_id": ObjectId("52720676445798e6728b45c6")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Speciality",
  "translation": "Спеціальність",
  "_id": ObjectId("5289cb7d44579889608b46a5")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Year of admission to school",
  "translation": "Рік вступу до ВНЗ",
  "_id": ObjectId("5289cb7d44579889608b46ab")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Student document serial number",
  "translation": "Серійний номер студентського квитку",
  "_id": ObjectId("5289cb7d44579889608b46af")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "First name (ukranian)",
  "translation": "Ім'я (українською)",
  "_id": ObjectId("5289cb7d44579889608b46b2")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Middle name (ukranian)",
  "translation": "По батькові (українською)",
  "_id": ObjectId("5289cb7d44579889608b46b3")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Last name (ukranian)",
  "translation": "Прізвище (українською)",
  "_id": ObjectId("5289cb7d44579889608b46b4")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "First name (english)",
  "translation": "Ім'я (англійською)",
  "_id": ObjectId("5289cb7d44579889608b46b5")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Middle name (english)",
  "translation": "По батькові (англійською)",
  "_id": ObjectId("5289cb7d44579889608b46b6")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Last name (english)",
  "translation": "Прізвище (англійською)",
  "_id": ObjectId("5289cb7d44579889608b46b7")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Current password",
  "translation": "Актуальний пароль",
  "_id": ObjectId("5289cb7d44579889608b46c0")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Set only if you want to change it",
  "translation": "Вкажіть, тільки якщо бажаєте змінити",
  "_id": ObjectId("5289cb7d44579889608b46c1")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "New password",
  "translation": "Новий пароль",
  "_id": ObjectId("5289cb7d44579889608b46c2")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Repeat new password",
  "translation": "Новий пароль ще раз",
  "_id": ObjectId("5289cb7d44579889608b46c3")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Home phone",
  "translation": "Домашній телефон",
  "_id": ObjectId("5289cb7d44579889608b46c5")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Mobile phone",
  "translation": "Мобільний телефон",
  "_id": ObjectId("5289cb7d44579889608b46c7")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "ACM Number",
  "translation": "Номер ACM",
  "_id": ObjectId("5289cb7d44579889608b46cb")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "School short name",
  "translation": "Коротка назва ВНЗ",
  "_id": ObjectId("5289cb7d44579889608b46cf")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Divison (I or II)",
  "translation": "Підрозділ (I або II)",
  "_id": ObjectId("5289cb7d44579889608b46d1")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "General info",
  "translation": "Основна інформація",
  "_id": ObjectId("5289cb7d44579889608b46d4")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Additional info (ukrainian)",
  "translation": "Додаткова інформація (українською)",
  "_id": ObjectId("5289cb7d44579889608b46d5")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Full university name in english",
  "translation": "Повна назва ВНЗ англійською",
  "_id": ObjectId("52720676445798e6728b45c7")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Short university name in ukrainian",
  "translation": "Коротка назва ВНЗ українською",
  "_id": ObjectId("52720676445798e6728b45c8")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Short university name in english",
  "translation": "Коротка назва ВНЗ англійською",
  "_id": ObjectId("52720676445798e6728b45c9")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Student can not be coordinator.",
  "translation": "Студент не може бути координатором",
  "_id": ObjectId("52720676445798e6728b45d9")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "{year} year",
  "translation": "{year} рік",
  "_id": ObjectId("52720676445798e6728b465e")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "News for the previous year: {year}",
  "translation": "Новини за попередній рік: {year}",
  "_id": ObjectId("52720676445798e6728b4665")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Year in which team participated",
  "translation": "Рік участі команди",
  "_id": ObjectId("5289cb7d44579889608b45d1")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Related coach ID",
  "translation": "ІН пов'язаного теренера",
  "_id": ObjectId("5289cb7d44579889608b45d2")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Related school ID",
  "translation": "ІН пов'язаного ВНЗ",
  "_id": ObjectId("5289cb7d44579889608b45d3")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "List of members",
  "translation": "Список учасників",
  "_id": ObjectId("5289cb7d44579889608b45d4")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "The number of members should be greater or equal then 3.",
  "translation": "Кількість учасників має бути не менша за 3.",
  "_id": ObjectId("5289cb7d44579889608b45d5")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "The number of members should be less or equal then 4.",
  "translation": "Кількість учасників має бути не більшою за 4.",
  "_id": ObjectId("5289cb7d44579889608b45d6")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "{attr} cannot be empty",
  "translation": "{attr} не може бути порожнім",
  "_id": ObjectId("5289cb7d44579889608b45d7")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "First name in Ukrainian",
  "translation": "Ім'я українською",
  "_id": ObjectId("5289cb7d44579889608b45df")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Middle name in Ukranian",
  "translation": "По батькові українською",
  "_id": ObjectId("5289cb7d44579889608b45e0")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Last name in Ukrainian",
  "translation": "Прізвище українською",
  "_id": ObjectId("5289cb7d44579889608b45e1")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "First name in English",
  "translation": "Ім'я англійською",
  "_id": ObjectId("5289cb7d44579889608b45e2")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Middle name in English",
  "translation": "По батькові англійською",
  "_id": ObjectId("5289cb7d44579889608b45e3")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Last name in English",
  "translation": "Прізвище англійською",
  "_id": ObjectId("5289cb7d44579889608b45e4")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Language of the information",
  "translation": "Мова інформації",
  "_id": ObjectId("5289cb7d44579889608b45f2")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "School name",
  "translation": "Назва ВНЗ",
  "_id": ObjectId("5289cb7d44579889608b45f7")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Short name of the school name",
  "translation": "Коротка назва ВНЗ",
  "_id": ObjectId("5289cb7d44579889608b45f8")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Division",
  "translation": "Підрозділ",
  "_id": ObjectId("5289cb7d44579889608b45f9")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "{attr} is incorrect",
  "translation": "{attr} некоректний",
  "_id": ObjectId("5289cb7d44579889608b4616")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "To manage teams, you must specify your school on the {a}profile page{\/a}.",
  "translation": "Для керування командами Ви маєте вказати ВНЗ на {a}сторінці профілю{\/a}.",
  "_id": ObjectId("5289cb7d44579889608b461f")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Coordinates",
  "translation": "Координатори",
  "_id": ObjectId("5289cb7d44579889608b462b")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Team Info",
  "translation": "Інформація про команду",
  "_id": ObjectId("5289cb7d44579889608b4641")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Short name of university (ukrainian)",
  "translation": "Коротка назва ВНЗ (українською)",
  "_id": ObjectId("5289cb7d44579889608b4643")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Full name of university (english)",
  "translation": "Повна назва ВНЗ (англійською)",
  "_id": ObjectId("5289cb7d44579889608b4644")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Short name of university (english)",
  "translation": "Коротка назва ВНЗ (англійською)",
  "_id": ObjectId("5289cb7d44579889608b4645")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Name of your team",
  "translation": "Назва команди",
  "_id": ObjectId("5289cb7d44579889608b4647")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Full name preview",
  "translation": "Попередній перегляд повної назви",
  "_id": ObjectId("5289cb7d44579889608b4648")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Name of your team with prefix",
  "translation": "Назва команди з префіксом",
  "_id": ObjectId("5289cb7d44579889608b4649")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Create a new team",
  "translation": "Створити нову команду",
  "_id": ObjectId("5289cb7d44579889608b4692")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Team name",
  "translation": "Назва команди",
  "_id": ObjectId("5289cb7d44579889608b4693")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "There are no teams.",
  "translation": "Немає жодної команди.",
  "_id": ObjectId("5289cb7d44579889608b4694")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Participants",
  "translation": "Учасники",
  "_id": ObjectId("5289cb7d44579889608b4698")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "No additional information for you.",
  "translation": "Додаткова інформація для Вас відсутня.",
  "_id": ObjectId("5289cb7d44579889608b46a2")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Additional info (english)",
  "translation": "Додаткова інформація (англійською)",
  "_id": ObjectId("5289cb7d44579889608b46d6")
});
db.getCollection("translation").insert({
  "category": "app",
  "language": "uk",
  "message": "Delete {file} ?",
  "translation": "Видалити {file} ?",
  "_id": ObjectId("5289cb7d44579889608b46d9")
});
