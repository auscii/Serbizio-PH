import 'package:flutter/material.dart';
import 'package:serbizio_ph/src/utils/constants/colors.dart';

class Categorycomp extends StatelessWidget {
  const Categorycomp(
      {super.key,
      required isSelected,
      required index,
      required category,
      required icon,
      required callBack})
      : _isSelected = isSelected,
        _categoryName = category,
        _icon = icon,
        _index = index;

  final int _isSelected;
  final int _index;
  final String _categoryName;
  final IconData _icon;

  @override
  Widget build(BuildContext context) {
    return InkWell(
      focusColor: Colors.transparent,
      hoverColor: Colors.transparent,
      splashColor: Colors.transparent,
      highlightColor: Colors.transparent,
      onTap: () {
        // _callBack(_index);
      },
      child: Container(
        padding: const EdgeInsets.symmetric(horizontal: 7, vertical: 7),
        margin: const EdgeInsets.symmetric(horizontal: 7, vertical: 7),
        decoration: const BoxDecoration(
          borderRadius: BorderRadius.all(
            Radius.circular(10),
          ),
          border: Border.fromBorderSide(BorderSide(
            width: 1,
            color: Colors.white
            )
          ),
          color: primaryColor
          // color: _isSelected == _index
          //     ? Colors.red
          //     : primaryColor,
        ),
        child: Row(
          children: [
            Icon(
              _icon,
              color: Colors.white,
              // color: _isSelected == _index
              //     ? Theme.of(context).colorScheme.surface
              //     : Theme.of(context).colorScheme.secondary,
              size: 20,
            ),
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 5),
              child: Text(
                _categoryName,
                style: const TextStyle(
                  color: Colors.white,
                )
                  // color: _isSelected == _index
                  //     ? Theme.of(context).colorScheme.surface
                  //     : Theme.of(context).colorScheme.secondary),
              ),
            ),
          ],
        ),
      ),
    );
  }
}
