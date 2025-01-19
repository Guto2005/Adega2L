<?php

//  define('SHOW_VARIABLES', 1);
//  define('DEBUG_LEVEL', 1);

//  error_reporting(E_ALL ^ E_NOTICE);
//  ini_set('display_errors', 'On');

set_include_path('.' . PATH_SEPARATOR . get_include_path());


include_once dirname(__FILE__) . '/' . 'components/utils/system_utils.php';
include_once dirname(__FILE__) . '/' . 'components/mail/mailer.php';
include_once dirname(__FILE__) . '/' . 'components/mail/phpmailer_based_mailer.php';
require_once dirname(__FILE__) . '/' . 'database_engine/mysql_engine.php';

//  SystemUtils::DisableMagicQuotesRuntime();

SystemUtils::SetTimeZoneIfNeed('America/Argentina/Buenos_Aires');

function GetGlobalConnectionOptions()
{
    return
        array(
          'server' => 'cc220df3eb53.sn.mynetname.net',
          'port' => '3306',
          'username' => 'gto_caveira',
          'password' => 'gto416966',
          'database' => 'gto_caveira',
          'client_encoding' => 'utf8'
        );
}

function HasAdminPage()
{
    return false;
}

function HasHomePage()
{
    return true;
}

function GetHomeURL()
{
    return 'index.php';
}

function GetHomePageBanner()
{
    return '';
}

function GetPageGroups()
{
    $result = array();
    $result[] = array('caption' => 'Default', 'description' => '');
    return $result;
}

function GetPageInfos()
{
    $result = array();
    $result[] = array('caption' => 'Produtos', 'short_caption' => 'Produtos', 'filename' => 'produtos.php', 'name' => 'produtos', 'group_name' => 'Default', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Marcas', 'short_caption' => 'Marcas', 'filename' => 'marcas.php', 'name' => 'marcas', 'group_name' => 'Default', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Equipamentos', 'short_caption' => 'Equipamentos', 'filename' => 'equipamentos.php', 'name' => 'equipamentos', 'group_name' => 'Default', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Clientes', 'short_caption' => 'Clientes', 'filename' => 'clientes.php', 'name' => 'clientes', 'group_name' => 'Default', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Cidades', 'short_caption' => 'Cidades', 'filename' => 'cidades.php', 'name' => 'cidades', 'group_name' => 'Default', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Servicos', 'short_caption' => 'Servicos', 'filename' => 'servicos.php', 'name' => 'servicos', 'group_name' => 'Default', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Bairros', 'short_caption' => 'Bairros', 'filename' => 'bairros.php', 'name' => 'bairros', 'group_name' => 'Default', 'add_separator' => false, 'description' => '');
    return $result;
}

function GetPagesHeader()
{
    return
        '<body>
    <img src="logo.png" alt="Logo">
</body>
    <style>
        img {
            width: 80px; /* Define a largura da imagem */
            height: auto; /* Mantém a proporção original */
        }
    </style>';
}

function GetPagesFooter()
{
    return
        '';
}

function ApplyCommonPageSettings(Page $page, Grid $grid)
{
    $page->SetShowUserAuthBar(false);
    $page->setShowNavigation(false);
    $page->OnGetCustomExportOptions->AddListener('Global_OnGetCustomExportOptions');
    $page->getDataset()->OnGetFieldValue->AddListener('Global_OnGetFieldValue');
    $page->getDataset()->OnGetFieldValue->AddListener('OnGetFieldValue', $page);
    $grid->BeforeUpdateRecord->AddListener('Global_BeforeUpdateHandler');
    $grid->BeforeDeleteRecord->AddListener('Global_BeforeDeleteHandler');
    $grid->BeforeInsertRecord->AddListener('Global_BeforeInsertHandler');
    $grid->AfterUpdateRecord->AddListener('Global_AfterUpdateHandler');
    $grid->AfterDeleteRecord->AddListener('Global_AfterDeleteHandler');
    $grid->AfterInsertRecord->AddListener('Global_AfterInsertHandler');
}

function GetAnsiEncoding() { return 'windows-1252'; }

function Global_AddEnvironmentVariablesHandler(&$variables)
{

}

function Global_CustomHTMLHeaderHandler($page, &$customHtmlHeaderText)
{

}

function Global_GetCustomTemplateHandler($type, $part, $mode, &$result, &$params, CommonPage $page = null)
{

}

function Global_OnGetCustomExportOptions($page, $exportType, $rowData, &$options)
{

}

function Global_OnGetFieldValue($fieldName, &$value, $tableName)
{

}

function Global_GetCustomPageList(CommonPage $page, PageList $pageList)
{

}

function Global_BeforeInsertHandler($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
{

}

function Global_BeforeUpdateHandler($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
{

}

function Global_BeforeDeleteHandler($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
{

}

function Global_AfterInsertHandler($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
{

}

function Global_AfterUpdateHandler($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
{

}

function Global_AfterDeleteHandler($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
{

}

function GetDefaultDateFormat()
{
    return 'Y-m-d';
}

function GetFirstDayOfWeek()
{
    return 0;
}

function GetPageListType()
{
    return PageList::TYPE_MENU;
}

function GetNullLabel()
{
    return null;
}

function UseMinifiedJS()
{
    return true;
}

function GetOfflineMode()
{
    return false;
}

function GetInactivityTimeout()
{
    return 0;
}

function GetMailer()
{
    $mailerOptions = new MailerOptions(MailerType::Sendmail, '', '');
    
    return PHPMailerBasedMailer::getInstance($mailerOptions);
}

function sendMailMessage($recipients, $messageSubject, $messageBody, $attachments = '', $cc = '', $bcc = '')
{
    GetMailer()->send($recipients, $messageSubject, $messageBody, $attachments, $cc, $bcc);
}

function createConnection()
{
    $connectionOptions = GetGlobalConnectionOptions();
    $connectionOptions['client_encoding'] = 'utf8';

    $connectionFactory = MySqlIConnectionFactory::getInstance();
    return $connectionFactory->CreateConnection($connectionOptions);
}

/**
 * @param string $pageName
 * @return IPermissionSet
 */
function GetCurrentUserPermissionsForPage($pageName) 
{
    return GetApplication()->GetCurrentUserPermissionSet($pageName);
}
