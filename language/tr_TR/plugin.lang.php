<?php
// +-----------------------------------------------------------------------+
// | Piwigo - a PHP based photo gallery                                    |
// +-----------------------------------------------------------------------+
// | Copyright(C) 2008-2014 Piwigo Team                  http://piwigo.org |
// | Copyright(C) 2003-2008 PhpWebGallery Team    http://phpwebgallery.net |
// | Copyright(C) 2002-2003 Pierrick LE GALL   http://le-gall.net/pierrick |
// +-----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify  |
// | it under the terms of the GNU General Public License as published by  |
// | the Free Software Foundation                                          |
// |                                                                       |
// | This program is distributed in the hope that it will be useful, but   |
// | WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU      |
// | General Public License for more details.                              |
// |                                                                       |
// | You should have received a copy of the GNU General Public License     |
// | along with this program; if not, write to the Free Software           |
// | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, |
// | USA.                                                                  |
// +-----------------------------------------------------------------------+
$lang['If empty, localhost and standard protocol ports will be used in configuration.'] = 'Eğer boş bırakılırsa, yapılandırmada yerel sunucu (localhost) ve standart protokol portları kullanılacaktır.';
$lang['If empty, standard protocol ports will be used by the software.'] = 'Eğer boş bırakılırsa yazılım tarafından standart protokol portları kullanılır';
$lang['Your password'] = 'LDAP şifreniz.';
$lang['Warning: LDAP Extension missing.'] = 'Uyarı: LDAP uzantısı eksik.';
$lang['Username'] = 'LDAP kullanıcı adınız';
$lang['Test Settings'] = 'Test ayarları';
$lang['Save'] = 'Kaydet';
$lang['Secure connexion'] = 'Güvenli bağlantı (LDAPS)';
$lang['Ldap connection credentials'] = 'LDAP bağlantı kimliği';
$lang['Let the fields blank if the ldap accept anonymous connections.'] = 'Eğer LDAP anonim bağlantıyı kabul ediyorsa alanları boş bırakın';
$lang['Ldap_Login Plugin'] = 'Ldap Oturum Açma Eklentisi';
$lang['Ldap_Login Test'] = 'Ldap Oturum Açma Test';
$lang['Ldap_Login configuration'] = 'Ldap Oturum Açma Yapılandırma';
$lang['Ldap server host connection'] = 'LDAP sunucu bağlantısı';
$lang['Ldap server host'] = 'LDAP sunucusu barındırıcı';
$lang['Ldap port'] = 'LDAP portu';
$lang['Bind password'] = 'Bağlı şifre';
$lang['Attribute corresponding to the user name'] = 'Kullanıcı adına karşılık gelen öz nitelik';
$lang['All LDAP users can use their ldap password everywhere on piwigo if needed.'] = 'Gerektiğinde tüm LDAP kullanıcıları Piwigo üzerinde LDAP şifrelerini kullanabilir.';
$lang['Base DN'] = 'LDAP kullanıcılarının bulunması gerektiğini ana DN (Örn: ou=kullanıcılar,dc=ornek,dc=com):';
$lang['You must save the settings with the Save button just up there before testing here.'] = 'Testten önce yukarıdaki Kaydet butonunu kullanarak ayarları kaydetmelisiniz.';
$lang['Bind DN, field in full ldap style'] = 'DN\'yi LDAP stiline bağla (Örn: cn=yonetici,dc=ornek,dc=com).';
$lang['New users when ldap auth is successfull'] = 'Yeni kullanıcılar - LDAP kimlik doğrulaması başarılı olduğunda';
$lang['Do you want admins to be advertised by mail in case of new users creation upon ldap login ?'] = 'Yöneticiler, LDAP oturumu açıldığında yeni kullanıcı yaratma durumundan eposta yoluyla bilgilendirilsin mi?';
$lang['Do you allow new piwigo users to be created when users authenticate succesfully on the ldap ?'] = 'Yeni kullanıcılar LDAP ile başarılı kimlik doğrulaması yaptıklarında yaratılsın mı?';
$lang['Do you want to send mail to the new users, like casual piwigo users receive ?'] = 'Yeni kullanıcılar diğer Piwigo kullanıcıları gibi eposta alsın mı?';
$lang['Users branch'] = 'LDAP kullanıcılarının bulunması gereken şube (ör.: ou=users):';
$lang['To get them out of these roles, they must be sorted of the ldap group and then role updated in the <a href="admin.php?page=user_list">piwigo admin</a>. If a group is mandatory as described in the <a href="admin.php?page=plugin-Ldap_Login-newusers">new piwigo users tab</a>, then they must also belong to the users group.'] = 'Onları bu rollerden çıkarmak için, ldap grubuna göre sıralanmaları ve ardından <a href="admin.php?page=user_list">piwigo admin</a>\'de rol güncellenmeleri gerekir. <a href="admin.php?page=plugin-Ldap_Login-newusers">Yeni piwigo kullanıcıları sekmesinde</a> açıklandığı gibi bir grup zorunluysa, bu grubun da users grubuna ait olması gerekir.';
$lang['Search Ldap users ?'] = 'Ldap kullanıcıları aransın mı? Kullanıcılarınızı birkaç şubede veya OU\'da yaygınlaştırdıysanız, buna ihtiyacınız olacak. Bundan kaçınırsanız, bir ldap isteği kaydedersiniz. ldap ağacınız basitse buna ihtiyacınız olmayabilir (örneğin: uid=user,ou=people,dc=example,dc=com).';
$lang['Search Ldap groups ?'] = 'Ldap kullanıcıları aransın mı? Gruplarınızı birkaç şubede veya OU\'da yaygınlaştırdıysanız, buna ihtiyacınız olacak. Bundan kaçınırsanız, bir ldap isteği kaydedersiniz. Eğer ldap ağacınız basitse buna ihtiyacınız olmayabilir (örneğin: cn=grupadı,ou=gruplar,dc=example,dc=com).';
$lang['Ldap users'] = 'LDAP kullanıcıları';
$lang['Ldap groups'] = 'LDAP grupları';
$lang['Groups branch'] = 'LDAP gruplarının bulunması gereken dal (ör.: ou=gruplar):';
$lang['If you create a <a href="admin.php?page=group_list">piwigo group</a> with the same name as an ldap one, all members of the ldap group will automatically join the piwigo group at their next authentication. This allows you to create <a href="admin.php?page=help&section=groups">specific right access management</a> (restrict access to a particaular album...).'] = 'Bir ldap grubuyla aynı ada sahip bir <a href="admin.php?page=group_list">piwigo grubu</a> oluşturursanız, ldap grubunun tüm üyeleri bir sonraki kimlik doğrulamalarında otomatik olarak piwigo grubuna katılır. Bu, <a href="admin.php?page=help&section=groups">belirli doğru erişim yönetimi</a> oluşturmanıza olanak tanır (belirli bir albüme erişimi kısıtlayın...). Ancak bu kullanıcıları devre dışı bırakmak için önce onları ldap gruplarından çıkarmanız gerekir, daha sonra piwigo grupları güncellenebilir.';