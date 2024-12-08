document.addEventListener('DOMContentLoaded', function() {
    showNotifications();
    setInterval(showNotifications, 5000);

    document.getElementById('notifications').style.display = 'none';

    document.getElementById('nf-btn').addEventListener('click', function() {
        var notifications = document.getElementById('notifications');
        if (notifications.style.display === 'none') {
            notifications.style.display = 'block';
            

        } else {
            notifications.style.display = 'none';
        }
        seenNotification();
    });

    document.getElementById('nf-btn').addEventListener('click', function(e) {
        e.stopPropagation();
    });

    document.documentElement.addEventListener('click', function() {
        document.getElementById('notifications').style.display = 'none';
    });
});

function showNotifications() {
    var ROOT = "http://localhost/bookBuddy/public";
    var xhr = new XMLHttpRequest();
    xhr.open('POST',ROOT+'/notifications', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (this.status == 200) {
            console.log(this.responseText);
            var data = JSON.parse(this.responseText);
            let contentData = data['notifications'];
            let data_count =data['total'] ;
            document.getElementById('notifications').innerHTML = '';
            
            if(contentData.length > 0){
                
                for (let i = 0; i < contentData.length; i++) {
                    let noti_date = contentData[i].date;
                    let noti_seen = contentData[i].seen;
                    let noti_message = contentData[i].message;
                   
            

                    let resultDiv = `
                       
                            <div class="noti-alert-${noti_seen}" role="alert" title="${noti_date}">
                                ${noti_message}
                            </div>
            
                       
                    `;
                    
                    document.getElementById('notifications').insertAdjacentHTML('beforeend', resultDiv);
                    document.getElementById('nf-n').innerHTML = data_count;
                }
            }else{
                document.getElementById('notifications').innerHTML = "<p>No Notifications</p>";
            }
        }
        
    };
    xhr.onerror = function() {
        console.error(xhr);
    };
    xhr.send(`key=123`);



}

function seenNotification() {
    var ROOT = "http://localhost/bookBuddy/public";
    var xhr = new XMLHttpRequest();
    xhr.open('POST',ROOT+'/notifications/seenNotification', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(`key=1234`);
}
