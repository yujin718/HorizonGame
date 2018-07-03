<script>
    var items = <?php echo $items; ?>;
    var attaches = [];
    var countAttach = 0;
    function addAttachment()
    {
        if (countAttach == 5)
        {
            swal('Already attached 5 items');
            return;
        }
        $('#attachDialog').modal();
        $('#attachQuantity').val('');
        changeAttachType();

    }
    function submitEmail()
    {
        if ($('#email_title').val() == '')
        {
            swal('Please input title');
            return;
        }
        $('#email_attach').val(JSON.stringify(attaches));
        $('#form_email').submit();
    }
    function changeAttachType()
    {
        changeIDsByType($('#attachType').val());
    }
    function clickAddAttach()
    {
        var quantity = $('#attachQuantity').val();
        if (quantity == '')
        {
            swal('Please add quantity');
            return;
        }
        var attach = {};
        attach['type'] = $('#attachType').val();
        attach['id'] = $('#attachID').val();
        attach['quantity'] = $('#attachQuantity').val();
        attach['txtID'] = $("#attachID option:selected").text();
        attach['txtType'] = $("#attachType option:selected").text();
        attaches[countAttach] = attach;
        countAttach++;
        updateAttachViews();
        $('#attachDialog').modal('hide');

    }
    function updateAttachViews()
    {
        $('#attachmentBody').empty();
        for (i = 0;i < attaches.length;i++)
        {
          var attach = attaches[i];
          var attachTag = "<a style='margin-right:10px;' onclick='removeAttach(\"" + attach['type'] + "\",\"" + attach['id'] + "\",\"" + attach['quantity'] + "\")'>(" + attach['txtType'] + ")   " + attach['txtID'] + "   " + attach['quantity'] + "</a>";
          $('#attachmentBody').append(attachTag);
        }
    }
    function removeAttach(type,id,quantity)
    {
        for (i = 0;i < attaches.length;i++)
        {
          var attach = attaches[i];
          if (attach['type'] == type && attach['id'] == id && attach['quantity'] == quantity)
          {
              attaches.splice(i,1);
              countAttach--;
              break;
          }
        }
        updateAttachViews();
    }
    function changeIDsByType(type)
    {
        $('#attachID').find('option').remove();
        if (type == 0)
        {
            idArray = JSON.parse(items[type]);
            for (i = 0;i < idArray.length;i++)
            {
                var option = "<option value='" + idArray[i].no + "'>" + idArray[i].name + "</option>";
                $('#attachID').append(option);
            }
        }
        else if (type == 1)
        {
            idArray = JSON.parse(items[type]);
            for (i = 0;i < idArray.length;i++)
            {
                var option = "<option value='" + idArray[i].SoulshardID + "'>" + idArray[i].Name + "</option>";
                $('#attachID').append(option);
            }
        }
        else if (type == 2)
        {
            idArray = JSON.parse(items[type]);
            for (i = 0;i < idArray.length;i++)
            {
                var option = "<option value='" + idArray[i].ItemID + "'>" + idArray[i].Name + "</option>";
                $('#attachID').append(option);
            }
        }
        else if (type == 3)
        {
            idArray = JSON.parse(items[type]);
            for (i = 0;i < idArray.length;i++)
            {
                var option = "<option value='" + idArray[i].EquipmentStatsID + "'>" + idArray[i].Name + "</option>";
                $('#attachID').append(option);
            }
        }
        else if (type == 4)
        {
            idArray = JSON.parse(items[type]);
            for (i = 0;i < idArray.length;i++)
            {
                var option = "<option value='" + idArray[i].CharacterStatsID + "'>" + idArray[i].Name + "</option>";
                $('#attachID').append(option);
            }
        }
    }
</script>
<div class="row">
    <div class="col-md-12" style="margin: 10px; padding-right:30px;">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#email" data-toggle="tab">Email</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="email">
                    <form method='post' id='form_email' action='<?php echo base_url() . 'index.php/AdminController/actionAddMail'; ?>'>
                        <input type='hidden' name='email_uid' id='email_uid' value='<?php echo $userInfo->PlayerID;?>'/></a>
                        <input type='hidden' name='email_attach' id='email_attach' value=''/></a>
                        <div class="modal-body">
                            <label for="exampleInputEmail1">Title</label>
                            <input class='form-control' type='text' name='email_title' id='email_title' value='' placeholder='Title'/></a>
                            <br>
                            <label for="exampleInputEmail1">Message</label>
                            <textarea class='form-control'  name='email_message' id='email_message' value='' placeholder='Message'/></textarea>
                            <br>
                            <label for="exampleInputEmail1">Attachment (To Remove Click Item)</label>
                            <div id="attachmentBody">

                            </div>
                            <a href='#' onclick="addAttachment()">+ Add Attachment</a>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default"><?php echo lang("text_79"); ?></button>
                            <button type="button" class="btn btn-primary" onclick='submitEmail()' >Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id='attachDialog'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Attachment</h4>
            </div>
              <div class="modal-body">
                  <label for="exampleInputEmail1">Select Type</label>
                  <select class='form-control' name='attachType' id='attachType' onchange="changeAttachType()">
                      <option value='0'>Currency</option>
                      <option value='1'>SoulShard</option>
                      <option value='2'>Item</option>
                      <option value='3'>Equipment</option>
                      <option value='4'>Character</option>
                  </select>
                  <br>
                  <label for="exampleInputEmail1">Select ID</label>
                  <select class='form-control' name='attachID' id='attachID'>

                  </select>
                  <br>
                  <label for="exampleInputEmail1">Quantity</label>
                  <input class='form-control' name='attachQuantity' id='attachQuantity' type='number'  value='' placeholder='Quantity'/>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("text_79"); ?></button>
                  <button type="button" class="btn btn-primary" onclick='clickAddAttach()'>Add</button>
              </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
