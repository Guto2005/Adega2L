<?php

include_once dirname(__FILE__) . '/' . 'phpgen_settings.php';
include_once dirname(__FILE__) . '/' . 'components/application.php';
include_once dirname(__FILE__) . '/' . 'components/security/permission_set.php';
include_once dirname(__FILE__) . '/' . 'components/security/user_authentication/table_based_user_authentication.php';
include_once dirname(__FILE__) . '/' . 'components/security/grant_manager/hard_coded_user_grant_manager.php';
include_once dirname(__FILE__) . '/' . 'components/security/table_based_user_manager.php';
include_once dirname(__FILE__) . '/' . 'components/security/user_identity_storage/user_identity_session_storage.php';
include_once dirname(__FILE__) . '/' . 'components/security/recaptcha.php';
include_once dirname(__FILE__) . '/' . 'database_engine/mysql_engine.php';

$grants = array('guest' => 
        array()
    ,
    'defaultUser' => 
        array('produtos' => new PermissionSet(false, false, false, false),
        'usuarios' => new PermissionSet(false, false, false, false),
        'marcas' => new PermissionSet(false, false, false, false),
        'equipamentos' => new PermissionSet(false, false, false, false),
        'clientes' => new PermissionSet(false, false, false, false),
        'cidades' => new PermissionSet(false, false, false, false),
        'itens' => new PermissionSet(false, false, false, false),
        'servicos' => new PermissionSet(false, false, false, false),
        'servicos.OSItens' => new PermissionSet(false, false, false, false),
        'bairros' => new PermissionSet(false, false, false, false),
        'ADG2L_Categorias' => new PermissionSet(false, false, false, false),
        'ADG2L_Categorias.ADG2L_Produtos' => new PermissionSet(false, false, false, false),
        'ADG2L_Fornecedor' => new PermissionSet(false, false, false, false),
        'ADG2L_Fornecedor.ADG2L_Produtos' => new PermissionSet(false, false, false, false),
        'ADG2L_Produtos' => new PermissionSet(false, false, false, false),
        'ADG2L_Produtos.ADG2L_VendaProdutos' => new PermissionSet(false, false, false, false),
        'ADG2L_Usuarios' => new PermissionSet(false, false, false, false),
        'ADG2L_Usuarios.ADG2L_Vendas' => new PermissionSet(false, false, false, false),
        'ADG2L_VendaProdutos' => new PermissionSet(false, false, false, false),
        'ADG2L_Vendas' => new PermissionSet(false, false, false, false),
        'ADG2L_Vendas.ADG2L_VendaProdutos' => new PermissionSet(false, false, false, false))
    ,
    'administrador' => 
        array('produtos' => new PermissionSet(false, false, false, false),
        'usuarios' => new PermissionSet(false, false, false, false),
        'marcas' => new PermissionSet(false, false, false, false),
        'equipamentos' => new PermissionSet(false, false, false, false),
        'clientes' => new PermissionSet(false, false, false, false),
        'cidades' => new PermissionSet(false, false, false, false),
        'itens' => new PermissionSet(false, false, false, false),
        'servicos' => new PermissionSet(false, false, false, false),
        'servicos.OSItens' => new PermissionSet(false, false, false, false),
        'bairros' => new PermissionSet(false, false, false, false),
        'ADG2L_Categorias' => new PermissionSet(false, false, false, false),
        'ADG2L_Categorias.ADG2L_Produtos' => new PermissionSet(false, false, false, false),
        'ADG2L_Fornecedor' => new PermissionSet(false, false, false, false),
        'ADG2L_Fornecedor.ADG2L_Produtos' => new PermissionSet(false, false, false, false),
        'ADG2L_Produtos' => new PermissionSet(false, false, false, false),
        'ADG2L_Produtos.ADG2L_VendaProdutos' => new PermissionSet(false, false, false, false),
        'ADG2L_Usuarios' => new PermissionSet(false, false, false, false),
        'ADG2L_Usuarios.ADG2L_Vendas' => new PermissionSet(false, false, false, false),
        'ADG2L_VendaProdutos' => new PermissionSet(false, false, false, false),
        'ADG2L_Vendas' => new PermissionSet(false, false, false, false),
        'ADG2L_Vendas.ADG2L_VendaProdutos' => new PermissionSet(false, false, false, false))
    );

$appGrants = array('guest' => new PermissionSet(false, false, false, false),
    'defaultUser' => new PermissionSet(false, false, false, false),
    'administrador' => new AdminPermissionSet());

$dataSourceRecordPermissions = array();

$tableCaptions = array('produtos' => 'Produtos',
'usuarios' => 'Usuarios',
'marcas' => 'Marcas',
'equipamentos' => 'Equipamentos',
'clientes' => 'Clientes',
'cidades' => 'Cidades',
'itens' => 'Itens',
'servicos' => 'Servicos',
'servicos.OSItens' => 'Servicos->ITENS DA OS',
'bairros' => 'Bairros',
'ADG2L_Categorias' => 'ADG2 L Categorias',
'ADG2L_Categorias.ADG2L_Produtos' => 'ADG2 L Categorias->ADG2 L Produtos',
'ADG2L_Fornecedor' => 'ADG2 L Fornecedor',
'ADG2L_Fornecedor.ADG2L_Produtos' => 'ADG2 L Fornecedor->ADG2 L Produtos',
'ADG2L_Produtos' => 'ADG2 L Produtos',
'ADG2L_Produtos.ADG2L_VendaProdutos' => 'ADG2 L Produtos->ADG2 L Venda Produtos',
'ADG2L_Usuarios' => 'ADG2 L Usuarios',
'ADG2L_Usuarios.ADG2L_Vendas' => 'ADG2 L Usuarios->ADG2 L Vendas',
'ADG2L_VendaProdutos' => 'ADG2 L Venda Produtos',
'ADG2L_Vendas' => 'ADG2 L Vendas',
'ADG2L_Vendas.ADG2L_VendaProdutos' => 'ADG2 L Vendas->ADG2 L Venda Produtos');

$usersTableInfo = array(
    'TableName' => 'phpgen_users',
    'UserId' => 'user_id',
    'UserName' => 'user_name',
    'Password' => 'user_password',
    'Email' => '',
    'UserToken' => '',
    'UserStatus' => ''
);

function EncryptPassword($password, &$result)
{

}

function VerifyPassword($enteredPassword, $encryptedPassword, &$result)
{

}

function BeforeUserRegistration($userName, $email, $password, &$allowRegistration, &$errorMessage)
{

}    

function AfterUserRegistration($userName, $email)
{

}    

function PasswordResetRequest($userName, $email)
{

}

function PasswordResetComplete($userName, $email)
{

}

function VerifyPasswordStrength($password, &$result, &$passwordRuleMessage) 
{

}

function CreatePasswordHasher()
{
    $hasher = CreateHasher('MD5');
    if ($hasher instanceof CustomStringHasher) {
        $hasher->OnEncryptPassword->AddListener('EncryptPassword');
        $hasher->OnVerifyPassword->AddListener('VerifyPassword');
    }
    return $hasher;
}

function CreateGrantManager() 
{
    global $grants;
    global $appGrants;
    
    return new HardCodedUserGrantManager($grants, $appGrants);
}

function CreateTableBasedUserManager() 
{
    global $usersTableInfo;

    $userManager = new TableBasedUserManager(MySqlIConnectionFactory::getInstance(), GetGlobalConnectionOptions(), 
        $usersTableInfo, CreatePasswordHasher(), false);
    $userManager->OnVerifyPasswordStrength->AddListener('VerifyPasswordStrength');

    return $userManager;
}

function GetReCaptcha($formId) 
{
    return null;
}

function SetUpUserAuthorization() 
{
    global $dataSourceRecordPermissions;

    $hasher = CreatePasswordHasher();

    $grantManager = CreateGrantManager();

    $userAuthentication = new TableBasedUserAuthentication(new UserIdentitySessionStorage(), false, $hasher, CreateTableBasedUserManager(), true, false, false);

    GetApplication()->SetUserAuthentication($userAuthentication);
    GetApplication()->SetUserGrantManager($grantManager);
    GetApplication()->SetDataSourceRecordPermissionRetrieveStrategy(new HardCodedDataSourceRecordPermissionRetrieveStrategy($dataSourceRecordPermissions));
}
