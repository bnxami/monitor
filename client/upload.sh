#!/bin/bash

#Datos Dinamicos
#while [ 1 ]; do

#-----Token
  mac=$(/sbin/ifconfig | grep -o -E '([[:xdigit:]]{1,2}:){5}[[:xdigit:]]{1,2}' | head -1)
   token=$(echo -n $mac | md5sum | cut -d " " -f1)
      echo "token=$token&" > /tmp/input;

    hora=$(date +%s);
      echo "hora=$hora&" >> /tmp/input;

#-----Nombre equipo

    nom=$(/bin/cat /etc/hostname);
      echo "nombre=$nom&" >> /tmp/input;
    users=$(/usr/bin/top | head -1 | cut -d "," -f2 | tr -d " " | cut -d "u" -f1);
      echo "usuarios=$users&" >> /tmp/input;
    tiempo_encendido=$(/usr/bin/uptime | tr -s " " "," | cut -d "," -f4);
      echo "tiempo_encendido=$tiempo_encendido&" >> /tmp/input;
        fecha_arranque_sistema=$(/usr/bin/who -b | cut -d " " -f13)
        hora_arranque_sistema=$(/usr/bin/who -b | cut -d " " -f14)
    arranque_sistema=$(echo $fecha_arranque_sistema $hora_arranque_sistema)
      echo "arranque_sistema=$arranque_sistema&" >> /tmp/input
    ip_publica=$(/usr/bin/wget -q icanhazip.com -O -);
      echo "ip_publica=$ip_publica&"  >> /tmp/input;

#-----CPU instalada
    procesador=$(/bin/cat /proc/cpuinfo | head -5 | tail -1 | cut -d ":" -f2 | sed 's/^.//g')
      echo "procesador=$procesador&" >> /tmp/input;
    cache_procesador=$(/bin/cat /proc/cpuinfo | grep 'cache size' | head -1 | cut -d ":" -f2 | tr -d " ")
      echo "cache_procesador=$cache_procesador&" >> /tmp/input;
    nucleos=$(/bin/cat /proc/cpuinfo | grep processor | wc -l)
      echo "nucleos=$nucleos&" >> /tmp/input;
        mhz_procesador=$(cat /proc/cpuinfo | grep 'cpu MHz' | head -1 | cut -d ":" -f2 | tr -d " " | cut -d "." -f1);
        #mhz_procesador=`echo  $mhz_procesador/1000 | bc -l`
    ghz_procesador=`echo 'scale=1;'"$mhz_procesador / 1000"|bc -l`
        echo "ghz_procesador=$ghz_procesador&" >> /tmp/input
    direc_fisic=$(/bin/cat /proc/cpuinfo | tail -3 | head -1 | cut -d ":" -f2 | cut -d "," -f1 | cut -d "p" -f1 |sed 's/^.//g')
      echo "direc_fisic=$direc_fisic&" >> /tmp/input;
    direc_logic=$(/bin/cat /proc/cpuinfo | tail -3 | head -1 | cut -d ":" -f2 | cut -d "," -f2 | cut -d "v" -f1 |sed 's/^.//g')
      echo "direc_logic=$direc_logic&" >> /tmp/input;

    uso_cpu=$(/usr/bin/vmstat 1 2 | tail -1 | tr -s " " "_" | cut -d "_" -f14)
      echo "uso_cpu=$uso_cpu&" >> /tmp/input;

#-----RAM en MB
    mem_total=$(/usr/bin/free -mt | head -2 | tail -1 | tr -s " " "_" | cut -d "_" -f2)
      echo "mem_total=$mem_total&" >> /tmp/input;
    mem_usada=$(/usr/bin/free -mt | head -2 | tail -1 | tr -s " " "_" | cut -d "_" -f3)
      echo "mem_usada=$mem_usada&" >> /tmp/input;
    mem_libre=$(/usr/bin/free -mt | head -2 | tail -1 | tr -s " " "_" | cut -d "_" -f4)
      echo "mem_libre=$mem_libre&" >> /tmp/input;
    mem_disponible=$(/usr/bin/free -mt | head -2 | tail -1 | tr -s " " "_" | cut -d "_" -f7)
      echo "mem_disponible=$mem_disponible&" >> /tmp/input;
    mem_cache=$(/usr/bin/free -mt | head -2 | tail -1 | tr -s " " "_" | cut -d "_" -f6);
      echo "mem_cache=$mem_cache&" >> /tmp/input;

    swap_total=$(/usr/bin/free -mt | grep 'Swap'| tr -s " " "_" | cut -d "_" -f2);
      echo "swap_total=$swap_total&" >> /tmp/input;
    swap_usada=$(/usr/bin/free -mt | head -3 | tail -1 | tr -s " " "_" | cut -d "_" -f3);
      echo "swap_usada=$swap_usada&" >> /tmp/input;
    swap_libre=$(/usr/bin/free -mt | head -3 | tail -1 | tr -s " " "_" | cut -d "_" -f4);
      echo "swap_libre=$swap_libre&" >> /tmp/input;
    mem_swap_total=$(/usr/bin/free -mt | head -4 | tail -1 | tr -s " " "_" | cut -d "_" -f2);
      echo "mem_swap_total=$mem_swap_total&" >> /tmp/input
    mem_usada_total=$(/usr/bin/free -mt | head -4 | tail -1 | tr -s " " "_" | cut -d "_" -f3);
      echo "mem_usada_total=$mem_usada_total&" >> /tmp/input
    mem_libre_total=$(/usr/bin/free -mt | head -4 | tail -1 | tr -s " " "_" | cut -d "_" -f4);
      echo "mem_libre_total=$mem_libre_total&" >> /tmp/input

#-----Red


      num_interficies=$(/sbin/ifconfig -s | grep -e "eth[0-9]" -e "enp0s[0-9]" | wc -l);
      num_interficies=$(($num_interficies + 1));


          for (( i = 1; i < $num_interficies; i++ )); do

            tarjeta_red=$(/sbin/ifconfig -s | grep -e "eth[0-9]" -e "enp0s[0-9]" | head -$i | tail -1 | cut -d " " -f1);
              Atarjeta[$i]="$tarjeta_red";

            ip_tarjeta=$(/sbin/ifconfig $tarjeta_red | grep -oiE '([0-9]{1,3}\.){3}[0-9]{1,3}' | grep -v 255);
              Aip_tarjeta[$i]="$ip_tarjeta";

            mask=$(/sbin/ifconfig $tarjeta_red | grep :255"."[0-255]"."[0-255]"."[0-255] | cut -d ":" -f4);
              Amask[$i]="$mask";

            gateway=$(ip route show | grep $tarjeta_red | grep default | awk {'print $3'});
              Agateway[$i]="$gateway";

            paquetes_recibidos=$(/bin/netstat -i $tarjeta_red  | head -3 | tail -1 | awk '{ print $4}')

            paquetes_enviados=$(/bin/netstat -i $tarjeta_red  | head -3 | tail -1 | awk '{ print $8}')

            #speed_in=$(/sbin/ifconfig | head -8 | grep -e 'Bytes RX:' -e 'RX packets' | cut -d "(" -f2 | cut -d ")" -f1)
            #speed_out=$(/sbin/ifconfig | head -8 | grep -e 'Bytes RX:' -e 'RX packets' | cut -d "(" -f3 | cut -d ")" -f1)

          echo "
                tarjetas[tarjeta$i]=$tarjeta_red&
                tarjetas[ip_$tarjeta_red]=$ip_tarjeta&
                tarjetas[mask_$tarjeta_red]=$mask&
                tarjetas[gateway_$tarjeta_red]=$gateway&
                tarjetas[paquetes_recibidos_$tarjeta_red]=$paquetes_recibidos&
                tarjetas[paquetes_enviados_$tarjeta_red]=$paquetes_enviados&" >> /tmp/input;
          done

#-----Discos

        num_discos=$(/bin/lsblk -l | grep 'disk' | wc -l );

        num_discos=$(($num_discos + 1));

        for (( i = 1; i < $num_discos; i++ )); do

          nom_disco=$(/bin/lsblk -l | grep 'disk' | head -$i | tail -1 | tr -s " " ";" | cut -d ";" -f1);

          tamano_disco=$(/bin/lsblk -l | grep 'disk' | head -$i | tail -1 | tr -s " " ";" | cut -d ";" -f4);

          disco_usado=$(/bin/df | grep $nom_disco | head -1 | tail -1 | tr -s " " ";" | cut -d ";" -f5);

          num_particiones=$(/bin/lsblk -l | grep $nom_disco[0-9] | wc -l);

                num_particiones=$(($num_particiones + 1));

              for (( x = 1; x < $num_particiones; x++ )); do

                    nom_particion=$(/bin/lsblk -l | grep $nom_disco[0-9] | head -$x | tail -1 |  tr -s " " ";" | cut -d ";" -f1);

                    tamano_particion=$(/bin/lsblk -l | grep $nom_particion | head -$x | tail -1 | tr -s " " ";" | cut -d ";" -f4);


                    #echo "discos[$nom_disco][tamano]=$tamano_disco&discos[$nom_disco][particiones][$nom_particion][tamano]=$tamano_particion&" >> /tmp/input;
                     echo "discos[disco$i]=$nom_disco&
                           discos[$nom_disco"_tamano"]=$tamano_disco&
                           discos[$nom_disco"_"$nom_particion]=$tamano_particion&" >> /tmp/input;
              done

      done


    fichero=$(/bin/cat /tmp/input | tr -d "\n" > /tmp/output);



    #upload=$(wget -O- --post-file=/tmp/output http://monitor.camisaca.com/input.php) > /tmp/descarga;
    upload=$(wget -O- --post-file=/tmp/output http://monitor.asix2-02.ticsimarro.org/input.php) > /tmp/descarga;
#sleep 3;

#done
