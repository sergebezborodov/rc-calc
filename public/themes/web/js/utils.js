function isSuccessResponce(json)
{
    if (json === undefined) {
        return false;
    }
    if (json['result'] != 'ok') {
        alert(json['message']);
        return false;
    }
    return true;
}
