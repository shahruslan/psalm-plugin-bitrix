# Psalm plugin bitrix

Дает возможность проанализировать ваш код, в котором вы используете классы bitrix. 

## Настройка

Пример конфигурации плагина:
```xml
<?xml version="1.0"?>
<psalm
    errorLevel="7"
    resolveFromConfigFile="true"
    autoloader="../bitrix/modules/main/cli/bootstrap.php"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xmlns="https://getpsalm.org/schema/config"
    xsi:schemaLocation="https://getpsalm.org/schema/config vendor/vimeo/psalm/config.xsd"
    findUnusedBaselineEntry="true"
    findUnusedCode="true"
>
    <projectFiles>
        <directory name="src"/>
        <ignoreFiles>
            <directory name="vendor"/>
        </ignoreFiles>
    </projectFiles>

    <plugins>
        <pluginClass class="Shahruslan\PsalmPluginBitrix\Plugin">
            <corePatch>../bitrix</corePatch>
            <customOrmAnnotation>../orm.php</customOrmAnnotation>
            <modules>
                <module name="iblock"/>
                <module name="search"/>
                <module name="sale"/>
                <module name="catalog"/>
            </modules>
        </pluginClass>
    </plugins>
</psalm>
```


`corePatch`: обязательно нужно указать путь к папке с ядром bitrix.  
`modules`: указываем какие модули используются в вашем коде.  
`customOrmAnnotation`: если вы сгенерировали файл аннотаций(php bitrix/bitrix.php orm:annotate), и используете в коде подсказки классов из
этого файла, то укажите его тут.  
