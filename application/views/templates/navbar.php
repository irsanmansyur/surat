<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="#" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img src="<?= base_url('assets/img/profile/' . $user['image']); ?>" alt=""><?= $user['nama']; ?>
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <?php if ($user['level'] == 'Admin') : ?>
                            <li><a href="<?= base_url('admin/profile'); ?>"><i class="fa fa-user"></i> Profile</a></li>
                        <?php else : ?>
                            <li><a href="<?= base_url('user/profile'); ?>"><i class="fa fa-user"></i> Profile</a></li>
                        <?php endif; ?>
                        <li><a href="<?= base_url('auth/logout'); ?>" class="tombol-logout"><i class="fa fa-sign-out"></i> Logout</a></li>
                    </ul>
                </li>


                <li class="">
                    <?php $count = $this->db->query("select count(*) as jumlah from tb_notif_chat where status_baca=0")->row_array(); ?>
                    <a href="#" class="user-profile dropdown-toggle" data-toggle="dropdown" id="notif" aria-expanded="false"><i class="fa fa-comments"></i> <span class="badge badge-danger"> <?= $count['jumlah'] ?> </span></a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">

                        <?php $sql = $this->db->query("select tb_notif_chat.pesan,tb_notif_chat.hash from tb_notif_chat join tb_chat on tb_notif_chat.hash=tb_chat.hash where status_baca=0 group by tb_notif_chat.hash order by id_nchat desc")->result();
                        foreach ($sql as $tampil) {
                            # code...


                        ?>
                            <?php if ($this->session->userdata('level') == 'Admin') { ?>
                                <li><a href="<?= base_url('admin/chat_index/' . $tampil->hash . ''); ?>"><i class="fa fa-user"></i><?= $tampil->pesan ?></a></li>
                            <?php

                            } else { ?>


                                <li><a href="<?= base_url('user/chat_index/' . $tampil->hash . ''); ?>"><i class="fa fa-user"></i><?= $tampil->pesan ?></a></li>

                        <?php }
                        } ?>
                    </ul>
                </li>



                <li class="" id="notif">
                    <?php $count = $this->db->query("select count(*) as jumlah from tb_notif where status_baca=0")->row_array(); ?>
                    <a href="#" class="user-profile dropdown-toggle" data-toggle="dropdown" id="notif" aria-expanded="false"><i class="fa fa-bell"> </i> <span class="badge badge-danger"> <?= $count['jumlah'] ?> </span></a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <?php $sql = $this->db->query("select * from tb_notif join tb_berkas on tb_notif.id_berkas=tb_berkas.id_berkas where status_baca=0")->result();
                        foreach ($sql as $tampil) {


                        ?>
                            <li><a href="<?= base_url('user/berkas_masuk/' . $tampil->id_berkas . '/' . $tampil->id_notif . ''); ?>"><i class="fa fa-user"></i><?= $tampil->nama_berkas ?></a></li>

                        <?php } ?>

                    </ul>
                </li>

            </ul>
        </nav>
    </div>
</div>
<!-- /top navigation -->
<script>
    $(document).ready(function() {

        //selesai();
        //setInterval(function(){
        $.ajax({

            url: "<?= base_url('Welcome/notifikasi') ?>",
            type: "POST",
            data: {},
            dataType: "JSON",
            success: function(data) {
                //alert(data.pesan);
                var html = '';
                var isi = '';
                var i;
                for (i = 0; i < data.length; i++) {
                    var html = '<a href="#" class="user-profile dropdown-toggle" data-toggle="dropdown" id="notif" aria-expanded="false"><i class="fa fa-bell"> </i> <span > ' + data[i].notif + ' </span></a> <ul class="dropdown-menu dropdown-usermenu pull-right"><li><a href="<?= base_url('admin/profile'); ?>"><i class="fa fa-user"></i>' + data[i].nama_berkas + '</a></li></ul>';


                }
                //$('#notif').html(html);

                // $('#notif').html(html);   

            }


        });
        //},2000);

    });

    function get_data() {

        $.ajax({

            url: "<?= base_url('Welcome/notifikasi') ?>",
            type: "POST",
            data: {},
            dataType: "JSON",
            success: function(data) {
                alert(data.pesan);
                document.getElementById("notif").innerHTML = data.pesan;



            }


        });
    }
</script>