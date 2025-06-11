import 'package:flutter/material.dart';
import 'package:icons_plus/icons_plus.dart';
import 'package:serbizio_ph/src/features/about/pages/about_page.dart';
import 'package:serbizio_ph/src/features/services/pages/services_page.dart';
import 'package:serbizio_ph/src/features/profile/pages/settings_page.dart';
import 'package:serbizio_ph/src/utils/constants/colors.dart';
import 'package:serbizio_ph/src/features/home/pages/home_page.dart';
import 'package:serbizio_ph/src/utils/helpers/helper_functions.dart';

class NavigationMenu extends StatefulWidget {
  const NavigationMenu({
    super.key
  });

  @override
  State<NavigationMenu> createState() => _NavigationMenuState();
}

class _NavigationMenuState extends State<NavigationMenu> {
  int _selectedIndex = 0;

  static const List<Widget> _pages = <Widget>[
    HomePage(),
    ServicesPage(), 
    AboutPage(),
    SettingsPage(),
  ];

  void _onItemTapped(int index) {
    setState(() {
      _selectedIndex = index;
    });
  }

  @override
  Widget build(BuildContext context) {
    final dark = HelperFunction.isDarkMode(context);

    return Scaffold(
      body: _pages[_selectedIndex],
      bottomNavigationBar: SizedBox(
        height: 65.0,
        child: Container(
          decoration: const BoxDecoration(
            // border: Border(top: BorderSide(color: textColor2, width: 0.5)),
          ),
          child: BottomNavigationBar(
            type: BottomNavigationBarType.fixed,
            // elevation: 0,
            currentIndex: _selectedIndex,
            onTap: _onItemTapped,
            iconSize: 30.0,
            selectedLabelStyle: const TextStyle(fontSize: 12.0),
            selectedItemColor: dark ? whiteColor : primaryColor,
            unselectedItemColor: dark ? whiteColor.withOpacity(0.7) : textColor2,
            items: <BottomNavigationBarItem> [
              BottomNavigationBarItem(icon: _selectedIndex==0 ? const Icon(MingCute.home_6_fill) : const Icon(MingCute.home_6_line), label: "Home"),
              BottomNavigationBarItem(icon: _selectedIndex==1 ? const Icon(MingCute.list_expansion_fill) : const Icon(MingCute.list_expansion_line), label: "Services"),
              BottomNavigationBarItem(icon: _selectedIndex==2 ? const Icon(MingCute.information_fill) : const Icon(MingCute.information_line), label: "About"),
              BottomNavigationBarItem(icon: _selectedIndex==3 ? const Icon(MingCute.settings_1_fill) : const Icon(MingCute.settings_1_line), label: "Settings"),
            ],
          ),
        ),
      ),
    );
  }
}
