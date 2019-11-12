# solveq
### Dokumentacja:  
Adres API: `http://matiusdevelopment.pl/`  
Pobieranie danych konta:  
request typu GET: http://matiusdevelopment.pl/Accounts?id=2  
Edycja konta/Dodawanie nowego:  
request typu POST: http://matiusdevelopment.pl/Accounts  
dane: {  
‘id’:1,    //opcjonalny ID konta, jeżeli wypełniony – akcja jest edycją, w przypadku braku – dodaje nowe konto  
‘name’: ‘imie’,  
‘surname’: ‘nazwisko’,  
‘email’:’adres@adres.pl’  
}  
Usuwanie konta:   
request typu DELETE: http://matiusdevelopment.pl/Accounts?id=2  
  
Pobieranie szczegółów transakcji:  
(GET) http://matiusdevelopment.pl/Transactions?id=2   
Zapisywanie nowej transakcji / edycja:  
(POST) http://matiusdevelopment.pl/Transactions  
data {  
id: 1, //id transakcji (opcjonalne)  
from_user: 1,  
to_user: 2,  
amount: 10.23,  
currency: PLN,  
title: tytuł przelewu  
}  
Transakcji nie można usuwać, można najwyżej dodać kolejną z ujemną kwotą tytułem STORNO  
  
  
Wywoływanie customowych akcji:  
Pobieranie stanu konta: (GET) http://matiusdevelopment.pl/Accounts/getBalance?id=2  
Pobieranie zestawienia transakcji: (GET) http://matiusdevelopment.pl/Accounts/printTransactions?id=2   
