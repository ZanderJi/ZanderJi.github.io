function ajax(url,type='GET',data='',dataType='text') {
    $.ajax({
        type: type,
        url: url,
        data: data,
        dataType: dataType,
        success: function (data) {
            return data;
        }
    })
}