import java.util.*;
public class indexing
{
	public static void main(String args[])
	{
		Scanner sc=new Scanner(System.in);
		int size=sc.nextInt();
		int fix=new int[size];
		int odd=new int[size];
		int even=new int[size];
		int k=0,l=0;
		for(int i=0;i<size;i++)
		{
			System.out.println("enter value: ");
			fix[i]=sc.nextInt();
		}
		System.out.println("entered array");
		for (int i;i<size;i++)
		{
			for (int j=0;j<size;j++)
			{
				if (arr[j]>arr[j+1])
				{
					int temp=arr[j];
					arr[j]=arr[j+1];
					arr[j+1]=temp;
				}
			}
		}
		for (int i=0;i<size;i++)
		{
			System.out.print(fix[i]+", ");
			if(fix[i]%2==0)
			{
				even[k++]=fix[i];
			}
			else
			{
                    odd[j++]=tns[i];
                }
            }
        System.out.println("\nEven array =");
        for(int i=0;i<k;i++)
            {
                System.out.print(even[i]+", ");
            }
        System.out.println("\nOdd Array = ");
        for(int i=0; i<j;i++)
            {
                System.out.print(odd[i]+", ");
            }
    }
}
