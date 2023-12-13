# mugroup-store

服务器开启唯一ip访问
firewall-cmd --permanent --add-rich-rule="rule family="ipv4" source address="192.168.0.1" port protocol="tcp" port="9001" accept"
firewall-cmd --reload
