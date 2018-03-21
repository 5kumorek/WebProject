         window.indexedDB = window.indexedDB || window.mozIndexedDB || window.webkitIndexedDB || window.msIndexedDB;
         
         //prefixes of window.IDB objects
         window.IDBTransaction = window.IDBTransaction || window.webkitIDBTransaction || window.msIDBTransaction;
         window.IDBKeyRange = window.IDBKeyRange || window.webkitIDBKeyRange || window.msIDBKeyRange
         
         if (!window.indexedDB) {
            window.alert("Your browser doesn't support a stable version of IndexedDB.")
         }
//function create(){
        var db;
         var request = window.indexedDB.open("newDatabase", 1);
         
         request.onerror = function(event) {
            //console.log("error: ");
         };
         
         request.onsuccess = function(event) {
            db = request.result;
            //add('elo',9);
         };
         
         request.onupgradeneeded = function(event) {
            var db = event.target.result;
            var objectStore = db.createObjectStore("employee", {keyPath: "name"});
			 
         }
//}create();
        

			var records="";	

         


		var myArray = new Array();
      	function getNames(){
			myArray = new Array();
			var objectStore = db.transaction("employee").objectStore("employee");
            objectStore.openCursor().onsuccess = function(event) {
               var cursor = event.target.result;
               if (cursor) {
                  //records+="<p>Name for id " + cursor.value.name + " is , Quantity: " + cursor.value.quantity+"</p>";
				   var a = [cursor.value.name, cursor.value.quantity];
				   myArray.push(a);
                  cursor.continue();
               }
            };
			return myArray;
			 //document.getElementById("container").innerHTML=records;//'lama';
         }
function c(){records='';}
        function remove(name) {
			
			//const dbStore = 'ArticlesStore';

			// 2. Open a new read/write transaction with the store within the database
			var request = db.transaction(["employee"], "readwrite").objectStore("employee");

			// 3. Delete the data corresponding to the passed key
			request.delete(name);
			// 4. Complete the transaction
			//return transaction.complete;	
		}
		function removeAll(){
			
			var arr = getNames();
			setTimeout(function(){
			if(arr.length!=0) {
			for(i=0;i<arr.length;i++)
				remove(arr[i][0]);
			//readAll();
			 document.getElementById('container').innerHTML = '';
				alert('Records are removed');
			} else {
				alert('Local database is empty');
			}
				}, 20);
		}

         function add(name, quantity) {
            var request = db.transaction(["employee"], "readwrite").objectStore("employee").add({ name: name, quantity: quantity });
            request.onsuccess = function(event) {
               //alert("product has been added to your database.");
            };
			 readAll();
			 document.getElementById('container').innerHTML = '';

            //request.onerror = function(event) {
               //alert("Unable to add data\r\nThis product is aready exist in your database! ");
            //}
         }

