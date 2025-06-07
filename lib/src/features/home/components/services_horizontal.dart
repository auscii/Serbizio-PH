import 'dart:ui';
import 'package:cached_network_image/cached_network_image.dart';
import 'package:flutter/material.dart';
import 'package:serbizio_ph/src/utils/constants/colors.dart';
import 'package:serbizio_ph/src/features/home/homecard/details_page.dart';
import 'package:shimmer/shimmer.dart';

class ServicesHorizontalView extends StatelessWidget {
  const ServicesHorizontalView({
    super.key, tag, image, serviceName, subTitle, icon}) : 
  _image = image,
  _tag = tag,
  _serviceName = serviceName,
  _subTitle = subTitle,
  _icon = icon;

  final String _tag;
  final String _serviceName;
  final String _image;
  final String _subTitle;
  final IconData _icon;

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.all(8.0),
      child: Card(
        elevation: 1,
        surfaceTintColor: Colors.transparent,
        color: primaryColor,
        shadowColor: primaryColor,
        child: ClipRRect(
          // borderRadius: const BorderRadius.all(Radius.circular(10)),
          child: BackdropFilter(
            filter: ImageFilter.blur(
              sigmaX: 10,
              sigmaY: 10,
              tileMode: TileMode.clamp,
            ),
            child: GestureDetector(
              onTap: () {
                // Navigator.of(context).push(
                //   MaterialPageRoute(
                //     builder: (context) {
                //       return const DetailScreen();
                //     },
                //     settings: RouteSettings(
                //       arguments: {"tag": _tag, "image": _image},
                //     ),
                //   ),
                // );
              },
              child: SizedBox(
                height: 150,
                width: 330,
                child: Row(
                  mainAxisAlignment: MainAxisAlignment.start,
                  children: [
                    Hero(
                      tag: _tag,
                      // child: Icon(
                      //   _icon,
                      //   size: 18,
                      //   color: Colors.orange,
                      // ),
                      child: CachedNetworkImage(
                        imageUrl: _image,
                        placeholder: (context, url) {
                          return SizedBox(
                            width: 150,
                            height: 150,
                            child: Shimmer.fromColors(
                              baseColor: Colors.red,
                              highlightColor: Colors.yellow,
                              child: Container(
                                height: 170,
                                color: Colors.white24,
                              ),
                            ),
                          );
                        },
                        errorWidget: (context, url, error) {
                          return SizedBox(
                            width: 150,
                            height: 150,
                            child: Shimmer.fromColors(
                              baseColor: Colors.red,
                              highlightColor: Colors.yellow,
                              child: Container(
                                height: 170,
                                color: Colors.white24,
                              ),
                            ),
                          );
                        },
                        width: 150,
                        height: 150,
                        fit: BoxFit.cover,
                      ),
                    ),
                    Column(
                      mainAxisAlignment: MainAxisAlignment.center,
                      crossAxisAlignment: CrossAxisAlignment.start,
                      mainAxisSize: MainAxisSize.min,
                      children: [
                        Padding(
                          padding: const EdgeInsets.symmetric(horizontal: 10),
                          child: Row(
                            children: [
                              Icon(
                                _icon,
                                size: 18,
                                color: Colors.white,
                              ),
                              Text(
                                " $_serviceName",
                                textAlign: TextAlign.center,
                                style: const TextStyle(
                                  fontSize: 16,
                                  color: Colors.white
                                ),
                              )
                            ],
                          ),
                        ),
                        Container(
                          padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 5),
                          width: 175,
                          child: Text(
                            _subTitle,
                            textAlign: TextAlign.start,
                            style: const TextStyle(
                              fontSize: 14,
                              color: Colors.white,
                              // overflow: TextOverflow.ellipsis
                            ),
                          ),
                        ),
                      ],
                    ),
                  ],
                ),
              ),
            ),
          ),
        ),
      ),
    );
  }
}
