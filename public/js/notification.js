function askForNotificationPermission(header, content) {
    if (Notification.permission !== 'denied') {
        Notification.requestPermission().then(permission => {
            if (permission === 'granted') {
                sendNotification(header, content);
            }
        });
    }
}

function sendNotification(header = "Başlık", content = "İçerik") {
    if (Notification.permission === 'granted') {
        new Notification(header, { body: content });
    }
}
