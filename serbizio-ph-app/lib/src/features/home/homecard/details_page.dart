import 'package:flutter/material.dart';
import 'package:serbizio_ph/src/features/home/homecard/place_detail_page.dart';

class DetailScreen extends StatefulWidget {
  const DetailScreen({super.key});

  @override
  State<DetailScreen> createState() => _DetailScreenState();
}

class _DetailScreenState extends State<DetailScreen> {
  @override
  Widget build(BuildContext context) {
    dynamic data = ModalRoute.of(context)!.settings.arguments;
    return Scaffold(
      extendBodyBehindAppBar: true,
      appBar: AppBar(
        excludeHeaderSemantics: true,
        toolbarHeight: 38,
        surfaceTintColor: Colors.transparent,
        leading: const BackButton(color: Colors.white),
        backgroundColor: Colors.transparent,
        actions: [
          IconButton(
              onPressed: () {},
              icon: const Icon(
                Icons.share,
                color: Colors.black,
              )),
          // Padding(
          //   padding: const EdgeInsets.only(top: 4, left: 5, right: 15),
          //   child: LikeButton(
          //     size: 27,
          //     likeBuilder: (isLiked) {
          //       return const Icon(
          //         // FontAwesomeIcons.solidHeart,
          //         Icons.favorite,
          //         color: Colors.black,
          //         size: 26,
          //       );
          //     },
          //   ),
          // ),
        ],
      ),
      body: Placedetailpage(data: data),
    );
  }
}
