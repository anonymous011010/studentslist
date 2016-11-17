    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?= $data['host'] ?>">Список студентов</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="<?= ($navHelper->isNavActive('index')) ? 'active' : '' ?>">
                        <a href="<?= $data['host'] ?>">Список</a>
                    </li>
                    <li class="<?= ($navHelper->isNavActive('form')) ? 'active' : '' ?>">
                        <a href="<?= $navHelper->getFormLink() ?>"><?= $navHelper->getFormNavTitle() ?></a>
                    </li>
                </ul>
                <form role="search" class="navbar-form navbar-right" method="get" action="<?= $data['host'] ?>/index/search/">
                    <div class="input-group add-on">
                        <input type="text" placeholder="Поиск" class="form-control" name="q" required value="<?= (isset($data['search'])) ? htmlentities($data['search'], ENT_QUOTES) : ''; ?>">
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-default" id="sbutton"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <!--/.nav-collapse -->
        </div>
    </nav>