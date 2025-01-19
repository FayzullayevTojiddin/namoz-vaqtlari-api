# namoz-vaqtlari-api
PHP asosida qurilgan API. Ushbu API islom.uz rasmiy sayti tomonidan parsing qilingan ma'lumotlardan yig'ilgan

O'zining maxsus Admin Paneli ham mavjud. Ushbu paneldan foydalanib qo'lda yangilashingiz ham mumkin ya'ni yangilash tugmasi orqali. Agar kiritilgan region mavjud bo'lsayu ma'lumotlar omborida bo'lmasa esa ushbu holda o'zi avtomatik yangilaydi ammo sal sekin ishlab foydalanuvchilaringizga Discomfort keltirishi mumkin. Shuni aytib o'tmoqchimanki agar ushbu API kerak bo'lsa bemalol foydalanishingiz mumkin.

ishlashi uchun:
1.php -S localhost:3000 run qiling

Endilikda sizda ushbu serverda run qilganingizdan so'ng ushbu API http://localhost:3000/hello.php?getTimes={region_raqami} kiritib olishingiz mumkin
Region index orqali olinadi. Ushbu Regionlar indexini olish uchun esa http://localhost:3000/hello.php?getRegion=true kiritib olishingiz mumkin.

JSON holida qaytadi javoblar. Ma`lumotlar ombori yo'q bo'lsa ham file orqali ishlatganman .json lar orqali. Chunki yaxshi ma'lumotlar ombori topa olmadim.
Kimdir buni xoxlasa o'zi uchun ma'lumotlar ombori qo'shishi mumkin tabga qarabda.

Yaqin orada InshaAllah bundan ham yaxshiroq ko'rinishga olib kelaman ushbu APIni requestlarini hisoblaydigan statistikali qilib hozirda sodda faqat ma'lumotlarni olish uchun mo'ljallangan ushbu kod
