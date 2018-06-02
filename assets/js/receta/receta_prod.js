$(document).ready(function() {
    // Ingredientes:
    $('#btnAdd').click(function() {
        var num     = $('.clonedInput').length; // how many "duplicatable" input fields we currently have
        var newNum  = new Number(num + 1);      // the numeric ID of the new input field being added

        // create the new element via clone(), and manipulate it's ID using newNum value
        var newSelElem = $('#select' + num).clone().attr('id', 'select' + newNum);
        var newCantElem = $('#cant' + num).clone().attr('id', 'cant' + newNum);
        var newUnitElem = $('#unit' + num).clone().attr('id', 'unit' + newNum);

        // manipulate the name/id values of the inputs inside the new element
        newSelElem.children(':first').attr('name', 'prod[' + (newNum-1) + '][id]');
        newCantElem.children(':first').attr('name', 'prod[' + (newNum-1) + '][cant]').val('');
        newUnitElem.children(':first').attr('name', 'prod[' + (newNum-1) + '][unit]');

        // insert the new element after the last "duplicatable" input field
        $('#unit' + num).after(newSelElem);
        newSelElem.after(newCantElem);
        newCantElem.after(newUnitElem);
      
        // enable the "remove" button
        $('#btnDel').prop('disabled', false);

        // Establece un límite
        /*if (newNum == 20)
            $('#btnAddInst').prop('disabled', true);*/

    });

    $('#btnDel').click(function() {
        var num = $('.clonedInput').length; // how many "duplicatable" input fields we currently have
        $('#select' + num).remove();     // remove the last element
        $('#cant' + num).remove();
        $('#unit' + num).remove();

        // enable the "add" button
        //$('#btnAdd').prop('disabled', false);

        // if only one element remains, disable the "remove" button
        if (num-1 == 1)
            $('#btnDel').prop('disabled', true);
    });

    // Instrucciones:
    $('#btnAddInst').click(function() {
        var num     = $('.clonedInputInst').length; // how many "duplicatable" input fields we currently have
        var newNum  = new Number(num + 1);      // the numeric ID of the new input field being added

        // create the new element via clone(), and manipulate it's ID using newNum value
        var newElem = $('#input' + num).clone().attr('id', 'input' + newNum);

        // manipulate the name/id values of the inputs inside the new element
        newElem.children(':first').attr('placeholder', 'Paso ' + newNum).val('');
  
        // insert the new element after the last "duplicatable" input field
        $('#input' + num).after(newElem);
      
        // enable the "remove" button
        $('#btnDelInst').prop('disabled', false);

        /*if (newNum == 20)
            $('#btnAddInst').prop('disabled', true);*/
    });

    $('#btnDelInst').click(function() {
        var num = $('.clonedInputInst').length;
        $('#input' + num).remove();

        // enable the "add" button
        //$('#btnAddInst').prop('disabled', false);

        // if only one element remains, disable the "remove" button
        if (num-1 == 1)
            $('#btnDelInst').prop('disabled', true);
    });

    if($('.clonedInputInst').length == 1) $('#btnDelInst').prop('disabled', true);

    if($('.clonedInput').length == 1) $('#btnDel').prop('disabled', true);
});