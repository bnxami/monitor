
#!/bin/bash
clear

echo -n "Escriba su nombre de usuario:"

read user

echo "Escriba su contraseña:"

read -s pass

hash=`echo -n $pass | openssl dgst -sha1 | cut -d " " -f2`

wget -O- --post-data="user=$user&password=$hash" http://monitor.asix2-02.ticsimarro.org/registro_equipo.php > /tmp/registro 2>/dev/null

result=`cat /tmp/registro`

if [[ $result == "si" ]]; then
  echo "Registrando equipo..."

    nom=$(/bin/cat /etc/hostname)
    mac=$(/sbin/ifconfig | grep -o -E '([[:xdigit:]]{1,2}:){5}[[:xdigit:]]{1,2}' | head -1)
    token=$(echo -n $mac | md5sum | cut -d " " -f1)

    wget -O- --post-data="user=$user&password=$hash&token=$token&equipo=$nom" http://monitor.asix2-02.ticsimarro.org/registro_equipo.php > /tmp/registro 2>/dev/null

    result=`cat /tmp/registro`

        if [[ $result == "siexiste" ]]; then
          echo "Este equipo ya esta registrado."

        else

          echo "Registro completado!"

        fi

else
    echo "El usuario y/o la contraseña no son correctos."

fi
