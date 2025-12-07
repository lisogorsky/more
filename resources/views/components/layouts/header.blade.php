 <header class="header">
     <div class="header__top">
         <div class="header__top-inner container">
             <div class="header__logo">
                 <a href="{{ url('/') }}">
                     <img src="{{ asset('images/logo.svg') }}" alt="Море Событий">
                 </a>
             </div>
             <div class="header__last-event">
                 <div class="header__event-heading">Фестиваль в Парке Культуры</div>
                 <div class="header__event-start">
                     <span class="header__discr">начнётся через</span>
                     <span class="header__time">22:48:15</span>
                 </div>
             </div>

             <div class="header__user-box">
                 @include('components.header.header-user')
             </div>

         </div>
     </div>
     <div class="header__bottom">
         <div class="header__bottom-inner container">
             <nav class="top-menu-wrap">
                 <ul class="top-menu">
                     <li class="top-menu__item"><a class="top-menu__link --active" href="#">События</a></li>
                     <li class="top-menu__item"><a class="top-menu__link" href="#">Организаторы</a></li>
                     <li class="top-menu__item"><a class="top-menu__link" href="#">Локации</a></li>
                     <li class="top-menu__item"><a class="top-menu__link" href="#">Партнёры</a></li>
                     <li class="top-menu__item"><a class="top-menu__link" href="#">Услуги</a></li>
                     <li class="top-menu__item"><a class="top-menu__link" href="#">Медиа контент</a></li>
                 </ul>
             </nav>
             <div class="search">
                 <form class="search-form" action="#" method="GET">
                     <div class="search-form__fields">
                         <input class="form-control search-form__input" type="text" name="query"
                             placeholder="Поиск" required>
                         <button class="search-form__submit" type="submit"><i class="icon-search"></i></button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </header>
