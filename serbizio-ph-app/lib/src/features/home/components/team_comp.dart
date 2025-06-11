import 'package:flutter/material.dart';
import 'package:gap/gap.dart';

class TeamComp extends StatelessWidget {
  const TeamComp({
    super.key,
    required teamName,
    required teamProfileImageURL,
    required teamMotto,
    required teamPosition
  }) :
  _teamName = teamName,
  // _teamProfileImageURL = teamProfileImageURL,
  // _teamMotto = teamMotto,
  _teamPosition = teamPosition;

  // final String _teamProfileImageURL;
  final String _teamName;
  // final String _teamMotto;
  final String _teamPosition;

  @override
  Widget build(BuildContext context) {
    return InkWell(
      focusColor: Colors.transparent,
      hoverColor: Colors.transparent,
      splashColor: Colors.transparent,
      highlightColor: Colors.transparent,
      child: Padding(
        padding: const EdgeInsets.symmetric(vertical: 3, horizontal: 5),
        child: SizedBox(
          height: 250,
          width: 90,
          child: Column(
            children: [
            // CircleAvatar(
            //   foregroundColor: Colors.pink,
            //   minRadius: 30,
            //   backgroundImage: NetworkImage(_teamProfileImageURL)
            // ),

            // CachedNetworkImage(
            //   imageUrl: _teamProfileImageURL,
            //   placeholder: (context, url) {
            //     return SizedBox(
            //       width: 150,
            //       height: 150,
            //       child: Shimmer.fromColors(
            //         baseColor: Colors.red,
            //         highlightColor: Colors.yellow,
            //         child: Container(
            //           height: 170,
            //           color: Colors.white24,
            //         ),
            //       ),
            //     );
            //   },
            //   errorWidget: (context, url, error) {
            //     return SizedBox(
            //       width: 150,
            //       height: 150,
            //       child: Shimmer.fromColors(
            //         baseColor: Colors.red,
            //         highlightColor: Colors.yellow,
            //         child: Container(
            //           height: 170,
            //           color: Colors.white24,
            //         ),
            //       ),
            //     );
            //   },
            //   width: 150,
            //   height: 150,
            //   fit: BoxFit.cover,
            // ),
            const Gap(5.0),
            Text(
              _teamPosition,
              textAlign: TextAlign.center,
              style: const TextStyle(color: Colors.black, fontWeight: FontWeight.bold),
            ),
            const Gap(5.0),
            Text(
              _teamName,
              textAlign: TextAlign.center,
              style: const TextStyle(color: Colors.black),
            ),
          ]),
        ),
      ),
    );
  }
}
