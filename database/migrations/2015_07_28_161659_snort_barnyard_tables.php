<?php

use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SnortBarnyardTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createSchemaTable();
        $this->createEventTable();
        $this->createSignatureTable();
        $this->createSignatureReferenceTable();
        $this->createReferenceTable();
        $this->createReferenceSystemTable();
        $this->createSignatureClassTable();
        $this->createSensorTable();
        $this->createIpHeaderTable();
        $this->createTcpHeaderTable();
        $this->createUdpHeaderTable();
        $this->createIcmpHeaderTable();
        $this->createOptionTable();
        $this->createDataTable();
        $this->createEncodingTable();
        $this->createDetailTable();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('schema');
        Schema::drop('event');
        Schema::drop('signature');
        Schema::drop('sig_reference');
        Schema::drop('reference');
        Schema::drop('reference_system');
        Schema::drop('sig_class');
        Schema::drop('sensor');
        Schema::drop('iphdr');
        Schema::drop('tcphdr');
        Schema::drop('udphdr');
        Schema::drop('icmphdr');
        Schema::drop('opt');
        Schema::drop('data');
        Schema::drop('encoding');
        Schema::drop('detail');
    }

    protected function createSchemaTable()
    {
        Schema::create('schema', function(Blueprint $table)
        {
            $table->integer('vseq')->unsigned();
            $table->dateTime('ctime');

            $table->primary('vseq');
        });

        DB::table('schema')->insert([
            'vseq' => 107,
            'ctime' => Carbon::now()
        ]);
    }

    protected function createEventTable()
    {
        Schema::create('event', function(Blueprint $table)
        {
            $table->integer('sid')->unsigned();
            $table->integer('cid')->unsigned();
            $table->integer('signature')->unsigned();
            $table->dateTime('timestamp');

            $table->primary(['sid','cid']);
            $table->index('signature','sig');
            $table->index('timestamp','time');
        });
    }

    protected function createSignatureTable()
    {
        Schema::create('signature', function(Blueprint $table)
        {
            $table->increments('sig_id');
            $table->char('sig_name');
            $table->integer('sig_class_id')->unsigned();
            $table->integer('sig_priority')->nullable();
            $table->integer('sig_rev')->nullable();
            $table->integer('sig_sid')->nullable();
            $table->integer('sig_gid')->nullable();

            $table->index('sig_name','sign_idx');
            $table->index('sig_class_id', 'sig_class_id_idx');
        });
    }

    protected function createSignatureReferenceTable()
    {
        Schema::create('sig_reference', function(Blueprint $table)
        {
            $table->integer('sig_id')->unsigned();
            $table->integer('ref_seq')->unsigned();
            $table->integer('ref_id')->unsigned();

            $table->primary(['sig_id','ref_seq']);
        });
    }

    protected function createReferenceTable()
    {
        Schema::create('reference', function(Blueprint $table)
        {
            $table->increments('ref_id');
            $table->integer('ref_system_id')->unsigned();
            $table->text('ref_tag');

        });
    }

    protected function createReferenceSystemTable()
    {
        Schema::create('reference_system', function(Blueprint $table)
        {
            $table->increments('ref_system_id');
            $table->char('ref_system_name', 20)->nullable();

        });
    }

    protected function createSignatureClassTable()
    {
        Schema::create('sig_class', function(Blueprint $table)
        {
            $table->increments('sig_class_id');     // sig_class_id        INT          UNSIGNED NOT NULL AUTO_INCREMENT,
            $table->char('sig_class_name', 60);     // sig_class_name      VARCHAR(60)  NOT NULL,

            $table->index('sig_class_id');
            $table->index('sig_class_name');
        });
    }

    protected function createSensorTable()
    {
        Schema::create('sensor', function(Blueprint $table)
        {
            $table->increments('sid');                      // sid          INT      UNSIGNED NOT NULL AUTO_INCREMENT,
            $table->text('hostname')->nullable();           // hostname     TEXT,
            $table->text('interface')->nullable();          // interface    TEXT,
            $table->text('filter')->nullable();             // filter       TEXT,
            $table->tinyInteger('detail')->nullable();      // detail       TINYINT,
            $table->tinyInteger('encoding')->nullable();    // encoding     TINYINT,
            $table->integer('last_cid')->unsigned();        // last_cid     INT      UNSIGNED NOT NULL,

        });
    }

    protected function createIpHeaderTable()
    {
        Schema::create('iphdr', function(Blueprint $table)
        {
            $table->integer('sid')->unsigned();                         // sid          INT      UNSIGNED NOT NULL,
            $table->integer('cid')->unsigned();                         // cid          INT      UNSIGNED NOT NULL,
            $table->integer('ip_src')->unsigned();                      // ip_src       INT      UNSIGNED NOT NULL,
            $table->integer('ip_dst')->unsigned();                      // ip_dst       INT      UNSIGNED NOT NULL,
            $table->tinyInteger('ip_ver')->nullable()->unsigned();      // ip_ver       TINYINT  UNSIGNED,
            $table->tinyInteger('ip_hlen')->nullable()->unsigned();     // ip_hlen      TINYINT  UNSIGNED,
            $table->tinyInteger('ip_tos')->nullable()->unsigned();      // ip_tos       TINYINT  UNSIGNED,
            $table->smallInteger('ip_len')->nullable()->unsigned();     // ip_len       SMALLINT UNSIGNED,
            $table->smallInteger('ip_id')->nullable()->unsigned();      // ip_id        SMALLINT UNSIGNED,
            $table->tinyInteger('ip_flags')->nullable()->unsigned();    // ip_flags     TINYINT  UNSIGNED,
            $table->smallInteger('ip_off')->nullable()->unsigned();     // ip_off       SMALLINT UNSIGNED,
            $table->tinyInteger('ip_ttl')->nullable()->unsigned();      // ip_ttl       TINYINT  UNSIGNED,
            $table->tinyInteger('ip_proto')->unsigned();                // ip_proto     TINYINT  UNSIGNED NOT NULL,
            $table->smallInteger('ip_csum')->nullable()->unsigned();    // ip_csum      SMALLINT UNSIGNED,

            $table->primary(['sid', 'cid']);                            // PRIMARY KEY (sid,cid),
            $table->index('ip_src', 'ip_src');                          // INDEX ip_src (ip_src),
            $table->index('ip_dst', 'ip_dst');                          // INDEX ip_dst (ip_dst));
        });
    }

    protected function createTcpHeaderTable()
    {
        Schema::create('tcphdr', function(Blueprint $table)
        {
            $table->integer('sid')->unsigned();                         // sid          INT      UNSIGNED NOT NULL,
            $table->integer('cid')->unsigned();                         // cid          INT      UNSIGNED NOT NULL,
            $table->smallInteger('tcp_sport')->unsigned();              // tcp_sport    SMALLINT UNSIGNED NOT NULL,
            $table->smallInteger('tcp_dport')->unsigned();              // tcp_dport    SMALLINT UNSIGNED NOT NULL,
            $table->integer('tcp_seq')->unsigned()->nullable();         // tcp_seq      INT      UNSIGNED,
            $table->integer('tcp_ack')->unsigned()->nullable();         // tcp_ack      INT      UNSIGNED,
            $table->tinyInteger('tcp_off')->unsigned()->nullable();     // tcp_off      TINYINT  UNSIGNED,
            $table->tinyInteger('tcp_res')->unsigned()->nullable();     // tcp_res      TINYINT  UNSIGNED,
            $table->tinyInteger('tcp_flags')->unsigned();               // tcp_flags    TINYINT  UNSIGNED NOT NULL,
            $table->smallInteger('tcp_win')->unsigned()->nullable();    // tcp_win      SMALLINT UNSIGNED,
            $table->smallInteger('tcp_csum')->unsigned()->nullable();   // tcp_csum     SMALLINT UNSIGNED,
            $table->smallInteger('tcp_urp')->unsigned()->nullable();    // tcp_urp      SMALLINT UNSIGNED,

            $table->primary(['sid', 'cid']);                            // PRIMARY KEY (sid,cid),
            $table->index('tcp_sport', 'tcp_sport');                    // INDEX       tcp_sport (tcp_sport),
            $table->index('tcp_dport', 'tcp_dport');                    // INDEX       tcp_dport (tcp_dport),
            $table->index('tcp_flags', 'tcp_flags');                    // INDEX       tcp_flags (tcp_flags));

        });

    }

    protected function createUdpHeaderTable()
    {
        Schema::create('udphdr', function(Blueprint $table)
        {
            $table->integer('sid')->unsigned();                         // sid 	        INT 	    UNSIGNED NOT NULL,
            $table->integer('cid')->unsigned();                         // cid 	        INT 	    UNSIGNED NOT NULL,
            $table->smallInteger('udp_sport')->unsigned();              // udp_sport    SMALLINT    UNSIGNED NOT NULL,
            $table->smallInteger('udp_dport')->unsigned();              // udp_dport    SMALLINT    UNSIGNED NOT NULL,
            $table->smallInteger('udp_len')->unsigned()->nullable();    // udp_len      SMALLINT    UNSIGNED,
            $table->smallInteger('udp_csum')->unsigned()->nullable();   // udp_csum     SMALLINT    UNSIGNED,

            $table->primary(['sid', 'cid']);                            // PRIMARY KEY (sid,cid),
            $table->index('udp_sport', 'udp_sport');                    // INDEX       udp_sport (udp_sport),
            $table->index('udp_dport', 'udp_dport');                    // INDEX       udp_dport (udp_dport))
        });
    }

    protected function createIcmpHeaderTable()
    {
        Schema::create('icmphdr', function(Blueprint $table)
        {
            $table->integer('sid')->unsigned();                         // sid 	        INT 	    UNSIGNED NOT NULL,
            $table->integer('cid')->unsigned();                         // cid 	        INT  	    UNSIGNED NOT NULL,
            $table->tinyInteger('icmp_type')->unsigned();               // icmp_type    TINYINT     UNSIGNED NOT NULL,
            $table->tinyInteger('icmp_code')->unsigned();               // icmp_code    TINYINT     UNSIGNED NOT NULL,
            $table->smallInteger('icmp_csum')->unsigned()->nullable();  // icmp_csum    SMALLINT    UNSIGNED,
            $table->smallInteger('icmp_id')->unsigned()->nullable();    // icmp_id      SMALLINT    UNSIGNED,
            $table->smallInteger('icmp_seq')->unsigned()->nullable();   // icmp_seq     SMALLINT    UNSIGNED,

            $table->primary(['sid', 'cid']);                            // PRIMARY KEY (sid,cid),
            $table->index('icmp_type','icmp_type');                     // INDEX       icmp_type (icmp_type)
        });
    }

    /**
     * Protocol options
     */
    protected function createOptionTable()
    {
        Schema::create('opt', function(Blueprint $table)
        {
            $table->integer('sid')->unsigned();                         // sid         INT      UNSIGNED NOT NULL,
            $table->integer('cid')->unsigned();                         // cid         INT      UNSIGNED NOT NULL,
            $table->integer('optid')->unsigned();                       // optid       INT      UNSIGNED NOT NULL,
            $table->tinyInteger('opt_proto')->unsigned();               // opt_proto   TINYINT  UNSIGNED NOT NULL,
            $table->tinyInteger('opt_code')->unsigned();                // opt_code    TINYINT  UNSIGNED NOT NULL,
            $table->smallInteger('opt_len')->unsigned()->nullable();    // opt_len     SMALLINT,
            $table->text('opt_data')->nullable();                       // opt_data    TEXT,

            $table->primary(['sid', 'cid', 'optid']);                   // PRIMARY KEY (sid,cid,optid));
        });
    }

    protected function createDataTable()
    {
        Schema::create('data', function(Blueprint $table)
        {
            $table->integer('sid')->unsigned();         // sid           INT      UNSIGNED NOT NULL,
            $table->integer('cid')->unsigned();         // cid           INT      UNSIGNED NOT NULL,
            $table->text('data_payload')->nullable();   // data_payload  TEXT,

            $table->primary(['sid','cid']);             // PRIMARY KEY (sid,cid)
        });
    }

    protected function createEncodingTable()
    {
        Schema::create('encoding', function(Blueprint $table)
        {
            $table->tinyInteger('encoding_type')->unsigned();
            $table->text('encoding_text');

            $table->primary('encoding_type');
        });

        DB::table('encoding')->insert([
            ['encoding_type' => 0, 'encoding_text' => 'hex'],
            ['encoding_type' => 1, 'encoding_text' => 'base64'],
            ['encoding_type' => 2, 'encoding_text' => 'ascii'],
        ]);
    }

    protected function createDetailTable()
    {
        Schema::create('detail', function(Blueprint $table)
        {
            $table->tinyInteger('detail_type')->unsigned(); // detail_type TINYINT UNSIGNED NOT NULL,
            $table->text('detail_text');                    // detail_text TEXT NOT NULL,

            $table->primary('detail_type');                 // PRIMARY KEY (detail_type)
        });

        DB::table('detail')->insert([
            ['detail_type' => 0, 'detail_text' => 'fast'],
            ['detail_type' => 1, 'detail_text' => 'full'],
        ]);
    }
}
