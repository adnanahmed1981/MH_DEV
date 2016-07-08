<body>
     <h1>Error <?php echo $data['code']; ?></h1>
     <h2><?php echo nl2br(CHtml::encode($data['message'])); ?></h2>
     <p>
        The above error occurred when the Web server was processing your request.
     </p>
     <p>
       If you think this is a server error, please contact <?php echo $data['admin']; ?>.
     </p>
     <p>
        Thank you.
     </p>
     <div class="version">
        <?php echo date('Y-m-d H:i:s',$data['time']) .' '. $data['version']; ?>
     </div>
</body>