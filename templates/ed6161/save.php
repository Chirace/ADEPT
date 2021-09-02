public function ED6161(Request $request, EntityManagerInterface $manager, $id) {
        $evaluation = $this->getDoctrine()->getManager()->getRepository(Evaluation::class)
            ->findOneById($id);
        
        $listeMotClefQ1 = $this->getDoctrine()->getRepository(EvaluationED6161::class)->findBy(
            array('evaluation' => $evaluation->getId(),
            'reperage_Q' => 1),
        );

        $listeMotClefQ2 = $this->getDoctrine()->getRepository(EvaluationED6161::class)->findBy(
            array('evaluation' => $evaluation->getId(),
            'reperage_Q' => 2)
        );

        $listeMotClefQ3 = $this->getDoctrine()->getRepository(EvaluationED6161::class)->findBy(
            array('evaluation' => $evaluation->getId(),
            'reperage_Q' => 3)
        );

        $listeMotClefQ4 = $this->getDoctrine()->getRepository(EvaluationED6161::class)->findBy(
            array('evaluation' => $evaluation->getId(),
            'reperage_Q' => 4)
        );

        $evaluationED6161_1 = new EvaluationED6161();
        $evaluationED6161_2 = new EvaluationED6161();
        $evaluationED6161_3 = new EvaluationED6161();
        $evaluationED6161_4 = new EvaluationED6161();

        $form1 = $this->createFormBuilder($evaluationED6161_1)
            ->add('secteur', SecteurType::class)
            ->add('posteDeTravail', PosteDeTravailType::class)
            ->add('valider', SubmitType::class, array('label'=> 'Continuer'))
            ->getForm();
        $form2 = $this->createFormBuilder($evaluationED6161_2)
            ->add('secteur', SecteurType::class)
            ->add('posteDeTravail', PosteDeTravailType::class)
            ->add('valider', SubmitType::class, array('label'=> 'Continuer'))
            ->getForm();
        $form3 = $this->createFormBuilder($evaluationED6161_3)
            ->add('secteur', SecteurType::class)
            ->add('posteDeTravail', PosteDeTravailType::class)
            ->add('valider', SubmitType::class, array('label'=> 'Continuer'))
            ->getForm();
        $form4 = $this->createFormBuilder($evaluationED6161_4)
            ->add('secteur', SecteurType::class)
            ->add('posteDeTravail', PosteDeTravailType::class)
            ->add('valider', SubmitType::class, array('label'=> 'Continuer'))
            ->getForm();
        
        /*if('POST' === $request->getMethod()) {
            if ($request->request->has('form1')) {*/
                $form1->handleRequest($request);
                if ($form1->isSubmitted() && $form1->isValid()) {
                    $secteur = $form1->get('secteur')->getData();
                    $posteDeTravail = $form1->get('posteDeTravail')->getData();
                    $manager->persist($secteur);
                    $manager->persist($posteDeTravail);
                    $manager->flush();
                    
                    $evaluationED6161_1->setEvaluation($evaluation);
                    $evaluationED6161_1->setSecteur($secteur);
                    $evaluationED6161_1->setPosteDeTravail($posteDeTravail);
                    $evaluationED6161_1->setReperageQ(1);
            
                    $manager->persist($evaluationED6161_1);
                    $manager->flush();
            
                    return $this->redirectToRoute('adept_tool_ED6161', ['id' => $id]);
                }
            //}

            //if ($request->request->has('form2')) {
                $form2->handleRequest($request);
                if ($form2->isSubmitted() && $form2->isValid()) {
                    $secteur = $form2->get('secteur')->getData();
                    $posteDeTravail = $form2->get('posteDeTravail')->getData();
                    $manager->persist($secteur);
                    $manager->persist($posteDeTravail);
                    $manager->flush();
            
                    $evaluationED6161_2->setEvaluation($evaluation);
                    $evaluationED6161_2->setSecteur($secteur);
                    $evaluationED6161_2->setPosteDeTravail($posteDeTravail);
                    $evaluationED6161_2->setReperageQ(2);
            
                    $manager->persist($evaluationED6161_2);
                    $manager->flush();
            
                    return $this->redirectToRoute('adept_tool_ED6161', ['id' => $id]);
                }
            //}

            //if ($request->request->has('form3')) {
                $form3->handleRequest($request);
                if ($form3->isSubmitted() && $form3->isValid()) {
                    $secteur = $form3->get('secteur')->getData();
                    $posteDeTravail = $form3->get('posteDeTravail')->getData();
                    $manager->persist($secteur);
                    $manager->persist($posteDeTravail);
                    $manager->flush();
            
                    $evaluationED6161_3->setEvaluation($evaluation);
                    $evaluationED6161_3->setSecteur($secteur);
                    $evaluationED6161_3->setPosteDeTravail($posteDeTravail);
                    $evaluationED6161_3->setReperageQ(3);
            
                    $manager->persist($evaluationED6161_3);
                    $manager->flush();
            
                    return $this->redirectToRoute('adept_tool_ED6161', ['id' => $id]);
                }
            //}

            //if ($request->request->has('form4')) {
                $form4->handleRequest($request);
                if ($form4->isSubmitted() && $form4->isValid()) {
                    $secteur = $form4->get('secteur')->getData();
                    $posteDeTravail = $form4->get('posteDeTravail')->getData();
                    $manager->persist($secteur);
                    $manager->persist($posteDeTravail);
                    $manager->flush();

                    $evaluationED6161_4->setEvaluation($evaluation);
                    $evaluationED6161_4->setSecteur($secteur);
                    $evaluationED6161_4->setPosteDeTravail($posteDeTravail);
                    $evaluationED6161_4->setReperageQ(4);

                    $manager->persist($evaluationED6161_4);
                    $manager->flush();

                    return $this->redirectToRoute('adept_tool_ED6161', ['id' => $id]);
                }
            //}
        //}
        return $this->render('ed6161/home.html.twig', array(
            'id' => $id,
            'listeMotClefQ1' => $listeMotClefQ1,
            'listeMotClefQ2' => $listeMotClefQ2,
            'listeMotClefQ3' => $listeMotClefQ3,
            'listeMotClefQ4' => $listeMotClefQ4,
            'form1' => $form1->createView(),
            'form2' => $form2->createView(),
            'form3' => $form3->createView(),
            'form4' => $form4->createView()
        ));
    }